
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    <div class="col-1 text-center">
        <div>
            <a wire:click.prevent = "vote(1)" href="#">
                <i class="fa fa-2x fa-sort-asc" aria-hidden="true"></i>
            </a>
        </div>
        <b>{{$sumVotes}}</b>
        <div>
            <a wire:click.prevent = "vote(-1)" href="#">
                <i class="fa fa-2x fa-sort-desc" aria-hidden="true"></i>
            </a>
        </div>
    </div>

