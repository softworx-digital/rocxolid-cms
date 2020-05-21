<div class="x_panel ajax-overlay">
    {!! $component->render('include.header-panel') !!}

    <div id="{{ $component->getDomId() }}" class="panel panel-primary">
        {!! $component->render('compose.header') !!}
        {!! $component->render('compose.body') !!}
        {!! $component->render('compose.footer') !!}
    </div>

    {!! $component->render('include.footer-panel') !!}
</div>

{!! $component->render('script.keditor-binding') !!}