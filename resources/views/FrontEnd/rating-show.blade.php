

@extends('layouts.landingpage')


@section('title')
    <title>Home, Situs Belanja Online dan Rental Car Mudah Terpercaya | Apy Rental A Car</title>
@endsection

@section('content')
    
      <!-- Average Rating Display -->
      <div class="at-rating">
        @php
            $fullStars = floor($averageRating);
            $halfStar = $averageRating - $fullStars >= 0.5 ? true : false;
            $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
        @endphp
        
        <!-- Full Stars -->
        @for($i = 0; $i < $fullStars; $i++)
            <i class="fa fa-star"></i>
        @endfor

        <!-- Half Star -->
        @if($halfStar)
            <i class="fa fa-star-half-o"></i>
        @endif

        <!-- Empty Stars -->
        @for($i = 0; $i < $emptyStars; $i++)
            <i class="fa fa-star-o"></i>
        @endfor

        <!-- Display Average Rating -->
        <span>({{ number_format($averageRating, 1) }})</span>
    </div>

    <!-- Display User Comments -->
    <div class="reviews">
        <h3>Customer Reviews</h3>

        @foreach ($reviews as $review)
            <div class="review">
                <strong>{{ $review->user->name }}</strong>
                <div class="review-rating">
                    @for($i = 0; $i < $review->rating; $i++)
                        <i class="fa fa-star"></i>
                    @endfor
                    @for($i = 0; $i < 5 - $review->rating; $i++)
                        <i class="fa fa-star-o"></i>
                    @endfor
                </div>
                <p>{{ $review->comment }}</p>
                <small>Reviewed on {{ $review->created_at->format('M d, Y') }}</small>
            </div>
            <hr>
        @endforeach

        @if($reviews->isEmpty())
            <p>No reviews yet. Be the first to leave a review!</p>
        @endif
    </div>

    <style>
    .at-rating i {
        color: #f5c518;
        font-size: 20px;
    }

    .reviews {
        margin-top: 30px;
    }

    .review {
        margin-bottom: 20px;
    }

    .review-rating i {
        color: #f5c518;
        font-size: 18px;
    }
  </style>

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>



@endsection