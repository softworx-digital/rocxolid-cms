<div id="{{ $component->getDomId(sprintf('panel.%s', $param)) }}" class="panel panel-{{ $class ?? 'default' }}">
    <div class="panel-heading">
        <h3 class="panel-title">{{ $component->translate(sprintf('panel.%s.heading', $param)) }}</h3>
    </div>
    <div class="panel-body">
        <dl class="dl-horizontal">
        @foreach ($component->getModel()->availableLocalizations() as $localization)
            <dt>
                <span>{{ Html::image(sprintf('vendor/softworx/rocXolid/images/flags/%s', $localization->country->flag), $localization->country->flag, [ 'class' => 'country-flag', 'style' => 'height: 15px;' ]) }}</span>
            </dt>
            @if ($component->getModel()->articleRoute($localization, $component->getModel()) !== '#')
            <dd><a href="{{ $component->getModel()->web->localizeUrl($localization) }}{{ $component->getModel()->articleRoute($localization, $component->getModel()) }}" target="_blank">{{ $component->getModel()->web->localizeUrl($localization) }}{{ $component->getModel()->articleRoute($localization, $component->getModel()) }}</a></dd>
            @else
            <dd><i class="fa fa-circle-o"></i></dd>
            @endif
        @endforeach
        </dl>
    </div>
</div>