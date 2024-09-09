

@extends('layouts.landingpage')


@section('title')
    <title>Home, Situs Belanja Online dan Rental Car Mudah Terpercaya | Apy Rental A Car</title>
@endsection

@section('content')
    
<div class="review-form">
        <form method="post" action="{{ route('ratings.store', $product) }}">
            @csrf
            <h3>Beri Rating dan Saran</h3>

            <!-- Star Rating -->
            <div class="star-rating">
                <input type="radio" name="rating" id="star5" value="5" required>
                <label for="star5">★</label>
                <input type="radio" name="rating" id="star4" value="4">
                <label for="star4">★</label>
                <input type="radio" name="rating" id="star3" value="3">
                <label for="star3">★</label>
                <input type="radio" name="rating" id="star2" value="2">
                <label for="star2">★</label>
                <input type="radio" name="rating" id="star1" value="1">
                <label for="star1">★</label>
            </div>

            <!-- Comment Textarea -->
            <div class="comment-section">
                <textarea name="comment" placeholder="Tulis komentar Anda di sini..." required>{{ old('comment') }}</textarea>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="submit-btn">Kirim Review</button>
        </form>
    </div>
</div>

<style>
    /* Styles for the review form */
    .container {
        max-width: 600px;
        margin: auto;
        padding: 20px;
    }

    .review-form h3 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }

    .star-rating {
        text-align: center;
        margin-bottom: 20px;
    }

    .star-rating label {
        font-size: 30px;
        color: #ccc;
        cursor: pointer;
    }

    .star-rating input {
        display: none;
    }

    .star-rating label:hover,
    .star-rating label:hover ~ label,
    .star-rating input:checked ~ label {
        color: #f5c518;
    }

    .comment-section textarea {
        width: 100%;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        resize: vertical;
        min-height: 150px;
        font-size: 16px;
    }

    .submit-btn {
        width: 100%;
        padding: 15px;
        background-color: #f5c518;
        border: none;
        border-radius: 5px;
        font-size: 18px;
        color: #fff;
        cursor: pointer;
    }

    .submit-btn:hover {
        background-color: #e6b306;
    }
</style>

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>



@endsection