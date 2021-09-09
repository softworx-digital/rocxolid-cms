<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-sm-5 col-xs-11">
                <h2 class="panel-title with-controls">{{ $component->translate('text.header') }}</h2>
            </div>
            <div class="col-sm-7 col-xs-1">
                <div class="btn-group btn-group-sm hidden-xs center-block pull-right" role="group">
                    <button
                        class="btn btn-default collapse-toggle collapsed"
                        data-toggle="collapse"
                        data-target="{{ $component->getDomIdHash('header') }}"
                        data-parent="{{ $component->getDomIdHash() }}"
                        data-label-hidden="{{ $component->translate('button.collapse-hidden') }}"
                        data-label-shown="{{ $component->translate('button.collapse-shown') }}">
                        <span class="title">{{ $component->translate('button.collapse-hidden') }}</span>
                        <i class="glyphicon glyphicon-chevron-down margin-left-5"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div id="{{ $component->getDomId('header') }}" class="panel-body panel-collapse collapse">
        {!! $component->render('include.perex-data') !!}
        <br />
    @if ($component->getModel()->headerImage()->exists())
        {!! $component->getModel()->headerImage->getModelViewerComponent()->render('related.show', [
            'attribute' => 'headerImage',
            'relation' => 'parent',
            'size' => '1920x',
        ]) !!}
    @else
        {!! $component->getModel()->headerImage()->make()->getModelViewerComponent()->render('related.unavailable', [
            'attribute' => 'headerImage',
            'relation' => 'parent',
            'related' => $component->getModel(),
            'placeholder' => 'header-placeholder',
        ]) !!}
    @endif
    </div>
</div>