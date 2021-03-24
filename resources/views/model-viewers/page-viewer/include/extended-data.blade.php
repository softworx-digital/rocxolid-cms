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
        <dl class="dl-horizontal">
            <dt>{{ $component->translate('field.dependencies') }}</dt>
            <dd>
                <ul>
                @foreach ($component->getModel()->provideDependencies() as $dependency)
                    <li><span>{{ $dependency->getTranslatedTitle($component->getController()) }}</span></li>
                @endforeach
                </ul>
            </dd>
        </dl>
    </div>
</div>