<div class="btn-group-vertical col-xs-12" data-toggle="buttons" {!! $component->getHtmlAttributes() !!}>
@foreach ($component->getFormField()->getCollection()->all() as $value => $item)
    <label class="btn btn-default has-controls text-wrap @if ($component->getFormField()->isFieldValue($item->getKey())) active @endif">
        {!! Form::radio($component->getFormField()->getFieldName(), $item->getKey(), $component->getFormField()->isFieldValue($item->getKey()), $component->getOption('attributes')) !!}
        <h4>{!! $item->getTitle() !!}</h4>
    @if (false)
        {!! $item->getModelViewerComponent()->render($component->getOption('collection-item-template'), [ 'no_elements_content' => sprintf('<p>(%s)</p>', $item->getModelViewerComponent()->translate('text.no_elements_content')) ]) !!}
    @endif

        <div class="btn-group btn-group-sm center-block hidden-xs show-up show-up-right" role="group">
        @can ('delete', [ $item ])
            <button class="btn btn-danger" data-ajax-url="{{ $item->getControllerRoute('destroyConfirm', [ '_data[model_id]' => $component->getFormField()->getForm()->getModel() ]) }}"><i class="fa fa-trash"></i></button>
        @endcan
        </div>
    </label>
@endforeach
@can ('create', $component->getFormField()->getPartModel())
    <a data-ajax-url="{{ $component->getFormField()->getPartModel()->getControllerRoute('create', [ sprintf('_data[%s]', $component->getFormField()->getForm()->getModel()->getForeignKey()) => $component->getFormField()->getForm()->getModel() ]) }}"  class="btn btn-primary text-wrap">
        <i class="fa fa-plus margin-right-5"></i>
        {{ $component->getFormField()->getPartModelComponent()->translate('button.create-new') }}
    </a>
@endcan
@if ($component->getFormField()->hasPartModel())
    <label class="btn btn-danger text-wrap">
        {!! Form::radio($component->getFormField()->getFieldName(), 0, false, $component->getOption('attributes')) !!}
        <i class="fa fa-unlink margin-right-5"></i>
        {{ $component->getFormField()->getPartModelComponent()->translate('button.detach') }}
    </label>
@endcan
</div>