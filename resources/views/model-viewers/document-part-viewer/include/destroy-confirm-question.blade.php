@if ($component->getModel()->elementables->isNotEmpty())
<p class="text-center">{{ $component->translate('model.title.singular') }} <b>{!! $component->getModel()->getTitle() !!}</b> {{ $component->translate('text.following-documents') }}</p>
<div class="text-center">
    <ul class="list-inline">
    @foreach ($component->getModel()->elementables as $elementable)
            <li><a class="label label-info" href="{{ $elementable->getControllerRoute('show') }}" target="_blank">{{ $elementable->getTitle() }}</a></li>
    @endforeach
    </ul>
</div>
@else
<p class="text-center">{{ $component->translate('model.title.singular') }} <b>{!! $component->getModel()->getTitle() !!}</b> {{ $component->translate('text.no-following-documents') }}</p>
@endif
<p class="text-center">{{ $component->translate('text.destroy-confirmation') }}?</p>