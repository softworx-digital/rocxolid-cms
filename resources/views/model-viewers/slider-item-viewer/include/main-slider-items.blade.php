<li id="{{ $component->getDomId('main-slider-items', md5(get_class($component->getModel())), $component->getModel()->getKey()) }}" class="" data-containee-id="{{ $component->getModel()->getKey() }}" data-containee-type="{{ get_class($component->getModel()) }}">
    <div class="row">
        <div class="col-xs-2 text-left actions">
            <div class="btn-group">
                <span class="btn btn-default btn-sm margin-right-no drag-handle"><i class="fa fa-arrows"></i></span>
                <a type="button" class="btn btn-primary btn-sm margin-right-no" title="{{ $component->translate('table-button.edit') }}" data-ajax-url="{{ $component->getModel()->getControllerRoute('edit', [ '_section' => 'main-slider-items', '_data[container_id]' => $container->getKey(), '_data[container_type]' => get_class($container), '_data[container_relation]' => 'items' ]) }}"><i class="fa fa-pencil"></i></a>
                <a type="button" class="btn btn-danger btn-sm margin-right-no"  title="{{ $component->translate('table-button.detach') }}" data-ajax-url="{{ $component->getModel()->getControllerRoute('detach', [ '_section' => 'main-slider-items', '_data[container_id]' => $container->getKey(), '_data[container_type]' => get_class($container), '_data[container_relation]' => 'items' ]) }}"><i class="fa fa-minus"></i></a>
            </div>
        </div>
        @if ($component->getModel()->image()->exists())
        <div class="col-xs-5">
            <div class="d-inline-block margin-right-10">
                <img src="{!! asset($component->getModel()->image->getPath('1280x500')) !!}"/>
            </div>
        </div>
        @endif
        <div class="col-xs-5">
        @if (!empty($component->getModel()->getTitle()))
            <span class="d-inline-block margin-bottom-5">{!! $component->getModel()->getTitle() !!}</span>
        @endif
        @if (!empty($component->getModel()->url))
            <p><a href="{{ $component->getModel()->url }}" target="_blank"><i class="fa fa-external-link margin-right-10"></i>{{ Str::limit($component->getModel()->url, 50) }}</a></p>
        @else
            @if ($component->getModel()->page()->exists())
                @if ($component->getModel()->userCan('read-only'))
                    <p><a class="label label-info" data-ajax-url="{{ $component->getModel()->page->getControllerRoute() }}">{!! $component->getModel()->page->getTitle() !!}</a></p>
                @else
                    <p><span class="label label-info">{!! $component->getModel()->page->getTitle() !!}</span></p>
                @endif
            @else
                <p><i class="fa fa-exclamation-triangle text-danger" title="{{ __('rocXolid::general.text.undefined') }} {{ $component->translate('field.url') }} / {{ $component->translate('field.page') }}"></i></p>
            @endif
        @endif
        @if (!empty($component->getModel()->text))
            <p class="d-block margin-top-5 border rounded">{!! $component->getModel()->text !!}</p>
        @endif
        @if (!empty($component->getModel()->button))
            <p class="d-block margin-top-5"><button class="btn">{!! $component->getModel()->button !!}</button></p>
        @endif
        @if (!empty($component->getModel()->template))
            <p class="d-block margin-top-5"><i class="fa fa-desktop margin-right-10"></i></span>{!! $component->getModel()->template !!}</p>
        @endif
        </div>
    </div>
</li>