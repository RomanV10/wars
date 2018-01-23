@if(!empty($items))
    @foreach ($items as $item)
        <a class="item-link" href="/api/item/add-rait?item_id={{ $item['id'] }}&api_id={{ $item['api_id'] }}">
            <div class="panel panel-default bg-white cursor-pointer" itemid="{{ $item['id'] }}">
                <div class="panel-body">
                <span class="col-md-8">
                    <h3 class="text-grey">{{ $item['title'] }}</h3>
                    <h4 class="text-light-grey">{{ $item['api_name'] }}</h4>
                    <h4 class="text-pink margin-bottom-0">{{ $item['score'] }} votes</h4>
                </span>
                </div>
                <div class="pink-line" style="width: {{ $item['score_percent'] }}%;"></div>
            </div>
        </a>
    @endforeach
@else
    <div class="alert alert-info">
        You need to enable api.
    </div>
@endif