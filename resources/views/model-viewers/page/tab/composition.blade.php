<div id="{{ $component->getDomId() }}" class="panel-group panel-group-collapsed">
    {!! $component->render('compose.header') !!}
    {!! $component->render('compose.body') !!}
    {!! $component->render('compose.footer') !!}
</div>

{!! $component->render('script.keditor-binding') !!}