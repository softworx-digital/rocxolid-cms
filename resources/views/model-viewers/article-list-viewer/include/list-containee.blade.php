<div id="{{ $component->getDomId('list-containee', $component->getModel()->id) }}">
@if ($component->getModel()->hasContainee('items'))
    <ul class="navigation sortable ajax-overlay" data-update-url="{{ $component->getModel()->getControllerRoute('reorder', [ 'relation' => 'items' ]) }}">
    @foreach ($component->getModel()->getContainees('items') as $item)
        <li id="{{ $item->getModelViewerComponent()->getDomId('list-containee', md5(get_class($item)), $item->id) }}" data-containee-id="{{ $item->id }}" data-containee-type="{{ get_class($item) }}" class="col-xxl-3 col-xl-4 col-lg-6 col-xs-12 height-150">
            <div class="row">
                <div class="col-xs-1 text-left actions">
                    <div class="btn-group-vertical">
                        <span class="btn btn-default btn-sm margin-right-no drag-handle"><i class="fa fa-arrows"></i></span>
                    @if (false)
                        <a type="button" class="btn btn-primary btn-sm margin-right-no"  title="{{ $component->translate('table-button.edit') }}" href="{{ $item->getControllerRoute('edit') }}" target="_blank"><i class="fa fa-pencil"></i></a>
                    @endif
                        <a type="button" class="btn btn-info btn-sm margin-right-no"  title="{{ $component->translate('table-button.show') }}" data-ajax-url="{{ $item->getControllerRoute('show') }}"><i class="fa fa-window-restore"></i></a>
                        <a type="button" class="btn btn-danger btn-sm margin-right-no"  title="{{ $component->translate('table-button.detach') }}" data-ajax-url="{{ $item->getControllerRoute('detach', [ '_section' => 'list-containee', '_data[container_id]' => $component->getModel()->id, '_data[container_type]' => get_class($component->getModel()), '_data[container_relation]' => 'items' ]) }}"><i class="fa fa-minus"></i></a>
                    </div>
                </div>
                <div class="col-xs-11">
                    <div class="col-xs-4 text-center">
                    @if ($item->imagePrimary && $item->imagePrimary()->exists())
                        <img style="max-width: 128px; max-height: 128px;" src="{!! asset($item->imagePrimary->getPath('small')) !!}"/>
                    @elseif ($item->image && $item->image()->exists())
                    <img style="max-width: 128px; max-height: 128px;" src="{!! asset($item->image->getPath('small')) !!}"/>
                    @endif
                    </div>
                    <div class="col-xs-8">
                        <p><big>{!! $item->getTitle() !!}</big></p>
                        <p>{{ $item->code }}</p>
                        <p>{{ $item->getFormattedPrice('price_vat') }}</p>
                    </div>
                </div>
            </div>
        </li>
    @endforeach
    </ul>
@endif
    <div class="clearfix"></div>
</div>