<?php
/**
 * Created by PhpStorm.
 * User: Vitor
 * Date: 06/03/2023
 * Time: 11:21
 */

namespace App\Validation;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;


class TaskValidation
{
    /**
     * List of constraints
     *
     * @var array
     */
    protected $rules = [];

    /**
     * List of customized messages
     *
     * @var array
     */
    protected $messages = [];

    /**
     * List of returned errors in case of a failing assertion
     *
     * @var array
     */
    protected $errors = [];

    /**
     * Model
     *
     * @var object
     */
    protected $model;

    /**
     * Action, Update or Create
     *
     * @var string
     */
    protected $action;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct($action = 'create')
    {
        $this->setAction($action);
        $this->initRules();
        $this->initMessages();
    }

    /**
     * Set the user subscription constraints
     *
     * @return void
     */
    public function initRules()
    {
        $this->rules['title'] = v::length(1, 200)->setName('title');
        $this->rules['description'] = v::optional(v::length(1, 5000))->setName('description');
        $this->rules['start_date'] = v::date('Y-m-d')->setName('start_date');
        $this->rules['conclusion_date'] = v::date('Y-m-d')->setName('conclusion_date');
    }

    /**
     * Set user custom error messages
     *
     * @return void
     */
    public function initMessages()
    {
        $this->messages = [
            'start_conclusion_date' => 'conclusion_date must be greater than start_date'
        ];
    }

    /**
     * Assert validation rules.
     *
     * @param object $model
     *   The inputs to validate.
     *
     * @return boolean
     *
     */
    public function assert(Model $model, Request $request)
    {
        foreach ($this->rules as $rule => $validator) {
            try {
                $validator->assert(Arr::get($model->getAttributes(), $rule));
            } catch (NestedValidationException $exception) {
                $this->formatErrorMessages($rule, $exception);

            }
        }

        $this->assertConclusionGreaterThanStartDate($request);

        if (count($this->errors)) {
            return false;
        }

        return true;
    }

    public function getErrors() {

        return $this->errors;
    }

    private function formatErrorMessages($rule, NestedValidationException $exception)
    {
        $messages = $exception->getMessages($this->messages);
        $messages = array_values(array_filter($messages));

        $this->errors[$rule] = $messages;
    }

    public function assertConclusionGreaterThanStartDate(Request $request)
    {

        try {
            $startDate = Carbon::createFromFormat('Y-m-d', $request->input('start_date'));
        } catch(\Exception $e) {
            return;
        }

        try {
            $conclusionDate = Carbon::createFromFormat('Y-m-d', $request->input('conclusion_date'));
        } catch(\Exception $e) {
            return;
        }

        if (!$conclusionDate->gt($startDate)) {
            $this->errors['start_conclusion_date'][] = $this->messages['start_conclusion_date'];
        }
    }

    public function setAction($action = 'create') {
        $this->action = $action;
    }
}
