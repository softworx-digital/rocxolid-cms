<div class="x_panel ajax-overlay">
    {!! $component->render('include.header-panel') !!}

    <div class="x_content">
    @foreach ($component->getModel()->getShowAttributes() as $field => $value)
        <div class="row">
            <label class="col-xs-6 text-right">{{ $component->translate(sprintf('field.%s', $field)) }}</label>
            <div class="col-xs-6">{{ $component->getModel()->$field }}</div>
        </div>
    @endforeach
    @foreach ($component->getModel()->getRelationshipMethods() as $method)
        <div class="row">
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

    <div class="x_footer">
        <a class="btn btn-default" href="{{ $component->getController()->getRoute('index') }}"><i class="fa fa-chevron-left margin-right-10"></i>{{ $component->translate('button.back', false) }}</a>
    @if ($component->getModel()->userCan('write'))
        <a href="{{ $component->getModel()->getControllerRoute('edit') }}" class="btn btn-primary pull-right"><i class="fa fa-pencil margin-right-10"></i>{{ $component->translate('button.edit', false) }}</a>
    @endif
    </div>
</div>