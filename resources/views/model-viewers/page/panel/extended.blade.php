@can ('view', $component->getModel())
<div id="{{ $component->getDomId(sprintf('panel.%s', $param)) }}" class="panel panel-{{ $class ?? 'default' }}">
    <div class="panel-heading">
        <h3 class="panel-title">
            {{ $component->translate(sprintf('panel.%s.heading', $param)) }}
            {!! $component->render('panel.snippet.link-edit-icon', [ 'param' => $param, 'template' => 'extended' ]) !!}
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
@endcan