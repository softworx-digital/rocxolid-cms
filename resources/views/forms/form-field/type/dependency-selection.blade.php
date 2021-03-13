<div class="control-group">
    {!! Form::hidden($component->getFormField()->getFieldName($index), null) !!}
    {!! Form::select($component->getFormField()->getFieldName($index), $component->getFormField()->getCollection(), $component->getFormField()->getFieldValue($index), $component->getOption('attributes')) !!}
</div>
@if ($component->getFormField()->hasDependencyFieldValuesFilterFields($index))
<div class="control-group control-group-additional margin-top-10 row">
@foreach ($component->getFormField()->getDependencyFieldValuesFilterFieldsComponents($component, $index) as $form_field_component)
    <div class="col-md-{{ floor(12 / $component->getFormField()->getDependencyFieldValuesFilterFieldsComponents($component, $index)->count()) }} col-xs-12">
        {!! $form_field_component->render($form_field_component->getOption('template', $form_field_component->getDefaultTemplateName())) !!}
    </div>
@endforeach
</div>
@endif