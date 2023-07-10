@extends('layouts.app')

@section('content')
    <div class="cards container">
        <?php $i = 1; ?>
        @foreach($products as $product)
             <a href="/products/{{$product->id}}" class="card ">{{-- {{$i%4 ? 'mr46': ''}} --}}
                <div class="imgs">
                    <img class="img1" src="{{asset('images/'.$product->image)}}" alt="{{$product->image}}">
                    <img class="img2" src="{{asset('images/'.$product->image2)}}" alt="{{$product->image2}}">
                </div>
                {{-- <img src="{{asset('icons/heart.svg')}}" class="wishlist-main"> --}}
                <div class="sizes-preview">
                    <?php
                        $sizes = explode(" ", $product->sizes);
                        foreach ($sizes as $num => $size) {
                            $s = "<div class=\"size ";
                            if (strval(substr($size, strpos($size, '.')+1)) == 0) { $s .= 'outof';}
                            $s .="\">".substr($size, 0, strpos($size, '.'))."</div>";
                            echo $s;
                        }
                    ?>
                </div>
                <h5 class="fw700 fs22">{{$product->name}}</h5>
                <h5 class="fw400 fs20">{{$product->content}}</h5>
                <h5 class="fw500 fs20">{{$product->price}}₴</h5>
            </a>
            <?php $i++; ?>
        @endforeach
    </div>
    <div class="pages">
        <nav>
            @if($products->currentPage()!=1)
                <a href="{{$products->previousPageUrl()}}">{{'<<'}} Prev Page</a>
            @else
                <span>{{'<<'}} Prev Page</span>
            @endif

            @for($i = 1; $i <= ceil($products->total()/$products->perPage()); $i++)
                <a @if($products->currentPage()==$i) class="page-a" @endif href="{{$products->url($i)}}">{{$i}}</a>
            @endfor

            @if($products->hasMorePages())
                <a href="{{$products->nextPageUrl()}}">Next Page >></a>
            @else
                <span>Next Page >></span>
            @endif
        </nav>
    </div>
@endsection

@section('prodscss')
    <link rel="stylesheet" href="{{asset('css/products.css')}}">
@endsection
@section('prodsjs')
    <script src="{{asset('js/products.js')}}"></script>
@endsection