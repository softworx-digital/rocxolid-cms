<li id="{{ $component->getDomId('main-navigation-items', md5(get_class($component->getModel())), $component->getModel()->getKey()) }}" class="" data-containee-id="{{ $component->getModel()->getKey() }}" data-containee-type="{{ get_class($component->getModel()) }}">
    <div class="row">
        <div class="col-xs-2 text-left actions">
            <div class="btn-group">
                <span class="btn btn-default btn-sm margin-right-no drag-handle"><i class="fa fa-arrows"></i></span>
                <a type="button" class="btn btn-primary btn-sm margin-right-no" title="{{ $component->translate('table-button.edit') }}" data-ajax-url="{{ $component->getModel()->getControllerRoute('edit', [ '_section' => 'main-navigation-items', '_data[container_id]' => $container->getKey(), '_data[container_type]' => get_class($container), '_data[container_relation]' => 'items' ]) }}"><i class="fa fa-pencil"></i></a>
                <a type="button" class="btn btn-danger btn-sm margin-right-no"  title="{{ $component->translate('table-button.detach') }}" data-ajax-url="{{ $component->getModel()->getControllerRoute('detach', [ '_section' => 'main-navigation-items', '_data[container_id]' => $container->getKey(), '_data[container_type]' => get_class($container), '_data[container_relation]' => 'items' ]) }}"><i class="fa fa-minus"></i></a>
            </div>
        </div>
        <div class="col-xs-10">
            <span class="d-inline-block margin-top-5">{!! $component->getModel()->getTitle() !!}</span>
            <span class="margin-left-10">{!! $component->render('include.link') !!}</span>
        </div>
    </div>
    <ul class="navigation vertical sortable margin-top-5 @if ($component->getModel()->getContainees('items')->isEmpty()) empty @endif">
    @foreach ($component->getModel()->getContainees('items') as $item)
        {!! $item->getModelViewerComponent()->render('include.main-navigation-items', [ 'container' => $component->getModel() ]) !!}
    @endforeach
    </ul>
</li>