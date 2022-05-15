@extends('layouts.master')
@section('body')
<!-- <h1>Discussion Board</h1> -->
<div class="container discussion_board mb-5">
    <!-- <div class="header bg-light shadow">
        <h4>Discussion Board</h4>
        <a class="create-post-btn btn">Create Post</a>
    </div> -->
    <div class="add_reply_section bg-light shadow">
        <div class="reply_header">
            <h4>Discussion Board</h4>
            <a class="create-reply-btn btn">Create Post</a>
        </div>
        <div class="add_reply_inputs">
            <form action="" id="postFrom">
                <div class="mb-3">
                    <label for="" class="form-label">Post Title</label>
                    <input type="text" name="post_title" class="form-control post_title" placeholder="Enter Title" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Post Description</label>
                    <textarea type="text" name="post_description" class="form-control reply-text-area post_description" placeholder="Enter Description" required></textarea>
                </div>
                <button type="submit" class="btn add-post-btn">Submit</button>
            </form>
            <button class="close-reply-secection">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-arrow-up-short" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 12a.5.5 0 0 0 .5-.5V5.707l2.146 2.147a.5.5 0 0 0 .708-.708l-3-3a.5.5 0 0 0-.708 0l-3 3a.5.5 0 1 0 .708.708L7.5 5.707V11.5a.5.5 0 0 0 .5.5z"/>
                </svg>
            </button>
            
        </div>
    </div>

    <div class="row question_cards_holder">

        @foreach ($posts as $post)
        <!--  -->
            <div class="col-lg-12 col-sm-12">
                <div id="post_{{$post->id}}" class="question_card bg-light shadow">
                    <div class="replies_box" data-toggle="tooltip" title="replies">
                        <p>{{$post->replies()->count()}}</p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-reply" viewBox="0 0 16 16">
                            <path d="M6.598 5.013a.144.144 0 0 1 .202.134V6.3a.5.5 0 0 0 .5.5c.667 0 2.013.005 3.3.822.984.624 1.99 1.76 2.595 3.876-1.02-.983-2.185-1.516-3.205-1.799a8.74 8.74 0 0 0-1.921-.306 7.404 7.404 0 0 0-.798.008h-.013l-.005.001h-.001L7.3 9.9l-.05-.498a.5.5 0 0 0-.45.498v1.153c0 .108-.11.176-.202.134L2.614 8.254a.503.503 0 0 0-.042-.028.147.147 0 0 1 0-.252.499.499 0 0 0 .042-.028l3.984-2.933zM7.8 10.386c.068 0 .143.003.223.006.434.02 1.034.086 1.7.271 1.326.368 2.896 1.202 3.94 3.08a.5.5 0 0 0 .933-.305c-.464-3.71-1.886-5.662-3.46-6.66-1.245-.79-2.527-.942-3.336-.971v-.66a1.144 1.144 0 0 0-1.767-.96l-3.994 2.94a1.147 1.147 0 0 0 0 1.946l3.994 2.94a1.144 1.144 0 0 0 1.767-.96v-.667z"/>
                        </svg>
                    </div>

                    @if($post->ownedByUser())
                        <div>
                            <button class="btn delete-post-btn">Delete</button>
                        </div>
                    @endif

                    <a href="{{ route('discussionBoard.show', $post->id) }}" class="question_title">{{$post->title}}</a>
                    <div class="owner_details">
                        <div class="user_picture shadow">
                            <img src="{{url('/')}}/images/prof_pic.jpg" style="width: 100%; height: 100%; border-radius: 11px;" alt="">
                        </div>
                        <div class="user_info">
                            <h4>{{$post->user->name}}</h4>
                            <p>{{$post->created_at}}</p>
                        </div>
                    </div>
                    <p class="question_text">{{$post->description}}</p>
                </div>
            </div>
        <!--  -->
        @endforeach
        

        <!-- <div class="col-lg-12 col-sm-12">
            <div class="question_card bg-light shadow">
                <div class="replies_box">
                    <p>5</p>
                    <svg data-toggle="tooltip" title="replies" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-reply" viewBox="0 0 16 16">
                        <path d="M6.598 5.013a.144.144 0 0 1 .202.134V6.3a.5.5 0 0 0 .5.5c.667 0 2.013.005 3.3.822.984.624 1.99 1.76 2.595 3.876-1.02-.983-2.185-1.516-3.205-1.799a8.74 8.74 0 0 0-1.921-.306 7.404 7.404 0 0 0-.798.008h-.013l-.005.001h-.001L7.3 9.9l-.05-.498a.5.5 0 0 0-.45.498v1.153c0 .108-.11.176-.202.134L2.614 8.254a.503.503 0 0 0-.042-.028.147.147 0 0 1 0-.252.499.499 0 0 0 .042-.028l3.984-2.933zM7.8 10.386c.068 0 .143.003.223.006.434.02 1.034.086 1.7.271 1.326.368 2.896 1.202 3.94 3.08a.5.5 0 0 0 .933-.305c-.464-3.71-1.886-5.662-3.46-6.66-1.245-.79-2.527-.942-3.336-.971v-.66a1.144 1.144 0 0 0-1.767-.96l-3.994 2.94a1.147 1.147 0 0 0 0 1.946l3.994 2.94a1.144 1.144 0 0 0 1.767-.96v-.667z"/>
                    </svg>
                    
                </div>
                <a href="#" class="question_title">Post Title</a>
                <div class="owner_details">
                    <div class="user_picture shadow"></div>
                    <div class="user_info">
                        <h4>User Name</h4>
                        <p>12th November</p>
                    </div>
                </div>
                <p class="question_text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa reprehenderit commodi ullam possimus. Est totam doloremque corporis dolor sapiente, iste, laudantium aliquid unde, debitis velit enim consequatur dolore nihil earum in magnam maiores error excepturi ab. Aperiam sit iusto sed quibusdam atque modi. Eum libero perspiciatis qui ad voluptas amet!</p>
            </div>
        </div> -->

    </div>


</div>


@endsection