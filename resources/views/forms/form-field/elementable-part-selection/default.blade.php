<div class="btn-group-vertical col-xs-12" data-toggle="buttons" {!! $component->getHtmlAttributes() !!}>
@foreach ($component->getFormField()->getCollection()->all() as $value => $item)
    <label class="btn btn-default text-wrap @if ($component->getFormField()->isFieldValue($item->getKey())) active @endif">
        {!! Form::radio($component->getFormField()->getFieldName(), $item->getKey(), $component->getFormField()->isFieldValue($item->getKey()), $component->getOption('attributes')) !!}
        <h4>{!! $item->getTitle() !!}</h4>
        {!! $item->getModelViewerComponent()->render($component->getOption('collection-item-template'), [ 'no_elements_content' => sprintf('<p>(%s)</p>', $item->getModelViewerComponent()->translate('text.no_elements_content')) ]) !!}
    </label>
@endforeach
@can ('create', $component->getFormField()->getPartModel())
    <a data-ajax-url="{{ $component->getFormField()->getPartModel()->getControllerRoute('create', [ '_data[document_id]' => $component->getFormField()->getForm()->getModel() ]) }}"  class="btn btn-primary text-wrap">
        <i class="fa fa-plus margin-right-5"></i>
        {{ $component->getFormField()->getPartModelComponent()->translate('button.create-new') }}
    </a>
@endcan
@if ($component->getFormField()->hasPartModel())
    <label class="btn btn-danger text-wrap">
        {!! Form::radio($component->getFormField()->getFieldName(), 0, $component->getFormField()->isFieldValue($item->getKey()), $component->getOption('attributes')) !!}
        <i class="fa fa-unlink margin-right-5"></i>
        {{ $component->getFormField()->getPartModelComponent()->translate('button.detach') }}
    </label>
@endcan
</div>