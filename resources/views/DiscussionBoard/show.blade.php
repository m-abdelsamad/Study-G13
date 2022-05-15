@extends('layouts.master')
@section('body')
<div class="single_question_post container mb-5">
    <div id="post_{{$post->id}}" class="question_section">
        <div class="replies_box" data-toggle="tooltip" title="replies">
            <p>{{$post->replies()->count()}}</p>
            <svg  xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-reply" viewBox="0 0 16 16">
                <path d="M6.598 5.013a.144.144 0 0 1 .202.134V6.3a.5.5 0 0 0 .5.5c.667 0 2.013.005 3.3.822.984.624 1.99 1.76 2.595 3.876-1.02-.983-2.185-1.516-3.205-1.799a8.74 8.74 0 0 0-1.921-.306 7.404 7.404 0 0 0-.798.008h-.013l-.005.001h-.001L7.3 9.9l-.05-.498a.5.5 0 0 0-.45.498v1.153c0 .108-.11.176-.202.134L2.614 8.254a.503.503 0 0 0-.042-.028.147.147 0 0 1 0-.252.499.499 0 0 0 .042-.028l3.984-2.933zM7.8 10.386c.068 0 .143.003.223.006.434.02 1.034.086 1.7.271 1.326.368 2.896 1.202 3.94 3.08a.5.5 0 0 0 .933-.305c-.464-3.71-1.886-5.662-3.46-6.66-1.245-.79-2.527-.942-3.336-.971v-.66a1.144 1.144 0 0 0-1.767-.96l-3.994 2.94a1.147 1.147 0 0 0 0 1.946l3.994 2.94a1.144 1.144 0 0 0 1.767-.96v-.667z"/>
            </svg>
            
        </div>
        @if($post->ownedByUser())
            <div>
                <form action="{{ route('discussionBoard.destroy', $post->id)}}" method="POST">
                    @method('delete')
                    @csrf
                    <button class="btn delete-post-from-page">Delete</button>
                </form>
            </div>
        @endif
        <h1 class="question_title">{{$post->title}}</h1>
        <div class="owner_details">
            <div class="user_picture shadow">
                <img src="{{url('/')}}/images/prof_pic.jpg" style="width: 100%; height: 100%; border-radius: 11px;" alt="">
            </div>
            <div class="user_info">
                <h4>{{$post->user->name}}</h4>
                <p>{{$post->created_at}}</p>
                <a href="{{url('/discussionBoard')}}" style="margin-top: -12px; color: black;" class="">Back</a>
            </div>
        </div>
        <p class="question_text mb-2">{{$post->description}}</p>
        
        <!-- <p class="question_text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae iure aliquid earum. Dolore tenetur alias numquam quae delectus facere ea sunt fuga esse similique quidem voluptate praesentium, corporis nostrum veritatis, odit sapiente at cumque ullam autem neque! Voluptatem doloribus aperiam dolorem voluptate corporis sint, fugiat a enim magnam? Amet provident iure, iste ad vitae asperiores similique id recusandae iusto aspernatur? Nulla aut autem natus eaque nisi, accusamus incidunt quia blanditiis alias, dolor perspiciatis cupiditate sit architecto quos facere eius repellat officia praesentium consequatur atque quis quibusdam reiciendis? Quo aperiam dolorum, molestias impedit, atque animi doloribus sint tempore ea ad deserunt.</p> -->
    </div>


    <div class="replies_section">
        <div class="add_reply_section bg-light shadow active" style="height: 400px !important;">
            <div class="reply_header">
                <h4>Add Reply</h4>
                <!-- <a class="create-reply-btn btn">Reply</a> -->
            </div>
            <div class="add_reply_inputs active" style="margin-top: 32px !important">
                <form id="addReplyForm" action="">
                    <div class="mb-2">
                        <textarea class="form-control reply-text-area reply_content" name="reply_content" id="" rows="3" placeholder="Reply Message" required></textarea>
                    </div>
                    <button class="btn add-reply-btn">Submit</button>
                </form>
                <!-- <button class="close-reply-secection">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-arrow-up-short" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 12a.5.5 0 0 0 .5-.5V5.707l2.146 2.147a.5.5 0 0 0 .708-.708l-3-3a.5.5 0 0 0-.708 0l-3 3a.5.5 0 1 0 .708.708L7.5 5.707V11.5a.5.5 0 0 0 .5.5z"/>
                    </svg>
                </button> -->
                
            </div>
        </div>


        <div class="replies row">

            @foreach ($post->replies as $reply)
                <div class="reply_holder col-lg-12 col-sm-12 mb-3">
                    <div class="reply bg-light shadow">
                        <h4>From ~ {{$reply->user->name}}</h4>
                        <p>{{$reply->content}}</p>
                    </div>
                </div>
            @endforeach
            
        </div>
        
    </div>
</div>
@endsection