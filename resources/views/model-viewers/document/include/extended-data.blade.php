<div id="{{ $component->getDomId('extended-data') }}" class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            {{ $component->translate('text.extended-data') }}
        @can ('update', $component->getModel())
            <a data-ajax-url="{{ $component->getController()->getRoute('edit', $component->getModel(), ['_section' => 'extended-data']) }}" class="margin-left-5 pull-right" title="{{ $component->translate('button.edit') }}"><i class="fa fa-pencil"></i></a>
        @endcan
        </h3>
    </div>
    <div class="panel-body">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">{{ $component->translate('field.dependencies') }}</h4>
            </div>
            <div class="panel-body">
                <ul>
                @foreach ($component->getModel()->provideDependencies() as $dependency)
                    <li>
                    @if ($dependency instanceof \Softworx\RocXolid\Models\Contracts\Crudable)
                        @can ('update', $dependency)
                            <a class="label label-info" href="{{ $dependency->getControllerRoute('edit') }}">{{ $dependency->getTranslatedTitle($component->getController()) }}</a>
                        @elsecan('view', $dependency)
                            <span>{{ $dependency->getTranslatedTitle($component->getController()) }}</span>
                        @endcan
                    @else
                        <span>{{ $dependency->getTranslatedTitle($component->getController()) }}</span>
                    @endif
                    </li>
                @endforeach
                </ul>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">{{ $component->translate('field.triggers') }}</h4>
            </div>
            <div class="panel-body">
                <ul>
                @foreach ($component->getModel()->provideTriggers() as $trigger)
                    <li><span>{{ $trigger->getTranslatedTitle($component->getController()) }}</span></li>
                @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>