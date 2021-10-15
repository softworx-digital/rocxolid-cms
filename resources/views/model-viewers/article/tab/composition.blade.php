<div id="{{ $component->getDomId() }}" class="panel-group panel-group-collapsed">
    {!! $component->render('compose.header') !!}
    {!! $component->render('compose.body') !!}
@if (false)
    {!! $component->render('include.content-data') !!}
@endif
</div>

{!! $component->render('script.keditor-binding') !!}