<div class="control-group">
    {!! Form::hidden($component->getFormField()->getFieldName($index), null) !!}
    {!! Form::select($component->getFormField()->getFieldName($index), $component->getFormField()->getCollection(), $component->getFormField()->getFieldValue($index), $component->getOption('attributes')) !!}
</div>
@if ($component->getFormField()->hasDependencyFieldValuesFilterFields($index))
<div class="control-group control-group-additional margin-top-5">
@foreach ($component->getFormField()->getDependencyFieldValuesFilterFieldsComponents($component, $index) as $form_field_component)
    {!! $form_field_component->render($form_field_component->getOption('template', $form_field_component->getDefaultTemplateName())) !!}
@endforeach
</div>
@endif