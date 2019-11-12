@if ($component->getModel() instanceof \Softworx\RocXolid\Models\Contracts\Containee)
<li data-page-element-id="{{ $component->getModel()->id }}" data-page-element-type="{{ get_class($component->getModel()) }}" data-containee-id="{{ $component->getModel()->id }}" data-containee-type="{{ get_class($component->getModel()) }}"@isset($component->getModel()->name) title="{{ $component->getModel()->name }}"@endif>
@else
<li data-page-element-id="{{ $component->getModel()->id }}" data-page-element-type="{{ get_class($component->getModel()) }}"@isset($component->getModel()->name) title="{{ $component->getModel()->name }}"@endif>
@endif
    <div class="block">
        <div class="tags">
            <a href="" class="tag"><span>{{ $component->translate('model.title.singular') }}</span></a>
        </div>
        <div class="block_content">
            <div class="row">
            @foreach ($component->getModel()->getShowAttributes([ 'id' ]) as $field => $value)
                @if (strip_tags($component->getModel()->$field) !== '')
                <div class="col-lg-3 col-md-4 col-xs-6">
                    <label class="col-xs-6 text-right">{{ $component->translate(sprintf('field.%s', $field)) }}</label>
                    <div class="col-xs-6">{!! $component->getModel()->$field !!}</div>
                </div>
                @endif
            @endforeach
            </div>
            <div class="row">
            @foreach ($component->getModel()->getRelationshipMethods([ 'web' ]) as $method)
                <div class="col-lg-3 col-md-4 col-xs-6">
                    <label class="col-xs-6 text-right">{{ $component->translate(sprintf('field.%s', $method)) }}</label>
                    <div class="col-xs-6">
                    @foreach ($component->getModel()->$method()->get() as $item)
                        @if ($item->userCan('read-only'))
                            <a class="label label-info" data-ajax-url="{{ $item->getControllerRoute() }}">{{ $item->getTitle() }}</a>
                        @else
                            <span class="label label-info">{{ $item->getTitle() }}</span>
                        @endif
                    @endforeach
                    </div>
                </div>
            @endforeach
            </div>
            <div class="row margin-top-10">
                {!! $component->render('include.images', [ 'page_elementable' => $page_elementable ]) !!}
            </div>
        </div>
        <div class="actions text-center">
            <div class="btn-group">
                <span class="btn btn-default btn-sm margin-right-no drag-handle"><i class="fa fa-arrows"></i></span>
            @if (isset($container))
                @if (false)
                    <a type="button" class="btn btn-primary btn-sm margin-right-no" title="{{ $component->translate('table-button.edit') }}" data-ajax-url="{{ $component->getModel()->getControllerRoute('edit', [ '_section' => 'page-elements', '_data[container_id]' => $container->id, '_data[container_type]' => get_class($container), '_data[container_relation]' => $page_elementable->getCCRelationParam() ]) }}"><i class="fa fa-pencil"></i></a>
                    <a type="button" class="btn btn-danger btn-sm margin-right-no"  title="{{ $component->translate('table-button.detach') }}" data-ajax-url="{{ $component->getModel()->getControllerRoute('detach', [ '_section' => 'page-elements', '_data[container_id]' => $container->id, '_data[container_type]' => get_class($container), '_data[container_relation]' => $page_elementable->getCCRelationParam() ]) }}"><i class="fa fa-minus"></i></a>
                @endif
            @else
                <a type="button" class="btn btn-primary btn-sm margin-right-no" title="{{ $component->translate('table-button.edit') }}" data-ajax-url="{{ $component->getModel()->getControllerRoute('edit', ['_section' => 'page-elements', $page_elementable->getRequestFieldName() => $page_elementable->id]) }}"><i class="fa fa-pencil"></i></a>
                <a type="button" class="btn btn-danger btn-sm margin-right-no" title="{{ $component->translate('table-button.clear') }}" data-ajax-url="{{ $component->getModel()->getControllerRoute('clear', ['_section' => 'page-elements', $page_elementable->getRequestFieldName() => $page_elementable->id]) }}"><i class="fa fa-trash-o"></i></a>
                <a type="button" class="btn btn-danger btn-sm margin-right-no"  title="{{ $component->translate('table-button.detach') }}" data-ajax-url="{{ $component->getModel()->getControllerRoute('detach', ['_section' => 'page-elements', $page_elementable->getRequestFieldName() => $page_elementable->id]) }}"><i class="fa fa-minus"></i></a>
            </div>

        @if (false)
            <div class="btn-group margin-top-5">
                <a type="button" class="btn btn-primary btn-sm margin-right-no" title="{{ $component->translate('table-button.regenerate') }}" data-ajax-url="{{ $component->getModel()->getControllerRoute('regenerate', ['_section' => 'page-elements', $page_elementable->getRequestFieldName() => $page_elementable->id]) }}"><i class="fa fa-refresh"></i></a>
                <a type="button" class="btn btn-danger btn-sm margin-right-no" title="{{ $component->translate('table-button.clear') }}" data-ajax-url="{{ $component->getModel()->getControllerRoute('clear', ['_section' => 'page-elements', $page_elementable->getRequestFieldName() => $page_elementable->id]) }}"><i class="fa fa-trash-o"></i></a>
            </div>
        @endif

        {{ Form::open([ 'id' => $component->makeDomId('pivot-data', md5(sprintf('%s-%s', get_class($component->getModel()), $component->getModel()->id))), 'class' => 'autosubmit ajax-overlay', 'url' => $page_elementable->getControllerRoute('setPivotData', [ 'page_elementable_type' => get_class($component->getModel()), 'page_elementable_id' => $component->getModel()->id ]) ]) }}
            @foreach ($component->getModel()->getPivotData() as $pivot_data => $value)
                @if (substr($pivot_data, 0, 3) == 'is_')
                    <br />
                    <label class="margin-top-10">
                        {{ Form::hidden(sprintf('_data[%s]', $pivot_data), 0) }}
                        <input type="checkbox" class="autosubmit" data-toggle="toggle" data-size="small" data-width="95" data-onstyle="success" @if ($value) checked="checked" @endif name="_data[{{ $pivot_data }}]" value="1"/>
                    </label>
                @endif
                @if ($component->getModel()->getParentPageElementable()->isPageElementTemplateChoiceEnabled() && ($pivot_data == 'template'))
                <div class="form-group">
                    {!! Form::select(sprintf('_data[%s]', $pivot_data), $component->getModel()->getTemplateOptions(), $value, [ 'class' => 'col-xs-12 autosubmit' ]) !!}
                </div>
                @endif
            @endforeach
                <button type="button" class="hidden" data-ajax-submit-form="{{ $component->makeDomIdHash('pivot-data', md5(sprintf('%s-%s', get_class($component->getModel()), $component->getModel()->id))) }}"><i class="fa fa-search"></i></button>
        {{ Form::close() }}
            @endif
        </div>
    </div>
@if ($component->getModel() instanceof \Softworx\RocXolid\Models\Contracts\Container)
    <ul class="list-inline containee-only">
    @foreach ($component->getModel()->getContainees($page_elementable->getCCRelationParam()) as $item)
        {!! $item->getModelViewerComponent()->render('in-page-elementable', [ 'page_elementable' => $page_elementable, 'container' => $component->getModel() ]) !!}
    @endforeach
    </ul>
@endif
</li>