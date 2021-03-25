<?php

namespace Softworx\RocXolid\CMS\ElementableDependencies\Rules;

use Illuminate\Contracts\Validation\Rule;
// rocXolid forms
use Softworx\RocXolid\Forms\AbstractCrudForm;
// rocXolid cms elementable dependency contracts
use Softworx\RocXolid\CMS\ElementableDependencies\Contracts\ElementableDependency;

/**
 * Rule that checks if the submitted form data conforms underlying ElementableDependency needs.
 *
 * @author softworx <hello@softworx.digital>
 * @package Softworx\RocXolid\CMS
 * @version 1.0.0
 */
class PassesDependenciesValidation implements Rule
{
    private $form;

    private $dependency;

    public function __construct(AbstractCrudForm $form)
    {
        $this->form = $form;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (is_null($value)) {
            return true;
        }

        list($dependency_type, $dependency_id) = explode(':', sprintf('%s:', $value));

        $this->dependency = filled($dependency_id) ? $dependency_type::withTrashed()->findOrFail($dependency_id) : app($dependency_type);

        if (!($this->dependency instanceof ElementableDependency)) {
            throw new \InvalidArgumentException(sprintf('Dependency type expected, [%s] given', get_class($value)));
        }

        return $this->dependency->validateAssignmentData(collect($this->form->getInput()), $attribute);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->dependency->assignmentValidationErrorMessage($this->form->getController(), collect($this->form->getInput()));
    }
}
