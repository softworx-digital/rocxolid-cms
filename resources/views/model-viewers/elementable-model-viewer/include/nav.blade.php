<ul id="{{ $component->getDomId('nav') }}" class="nav nav-tabs nav-justified">
    <li role="presentation" @if (!isset($tab) || ($tab === 'default'))class="active"@endif><a href="{{ $component->getController()->getRoute('show', $component->getModel()) }}">{!! $component->translate('tab.default') !!}</a></li>
    <li role="presentation" @if (isset($tab) && ($tab === 'composition'))class="active"@endif><a href="{{ $component->getController()->getRoute('show', $component->getModel(), [ 'tab' => 'composition' ]) }}">{!! $component->translate('tab.composition') !!}</a></li>
</ul>