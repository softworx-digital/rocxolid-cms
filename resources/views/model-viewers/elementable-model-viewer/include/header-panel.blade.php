<div id="{{ $component->getDomId('header-panel') }}" class="x_title margin-bottom-0" style="border: 0;">
    <div class="row">
    @if ($component->getModel()->exists)
        <div class="col-md-6 col-xs-12">
            <h2 class="text-overflow"><span class="text-big">{!! $component->getModel()->getTitle() !!}</span></h2>
        </div>
        <div class="col-md-6 col-xs-12 text-right hidden-sm">
            <h2 class="text-overflow">
                <small>{{ $component->translate(sprintf('action.%s', $route_method)) }}</small>
                <span class="model-class-title">{{ $component->translate('model.title.singular') }}</span>
            </h2>
        </div>
    @else
        <div class="col-xs-12">
            <h2 class="text-overflow">
                <small class="pull-left">{{ $component->translate(sprintf('action.%s', $route_method)) }}</small>
                <span class="model-class-title">{{ $component->translate('model.title.singular') }}</span>
            </h2>
        </div>
    @endif
    </div>
</div>