@extends('layouts.master')
@section('body')
<div class="hero d-flex align-items-center justify-content-center">
    <h1 class="main-heading" style="font-size: 150px; color: white; text-shadow: 10px 30px 50px rgb(0 0 0);">Welcome to Study +</h1>
    <div class="bg-img" style="background-image: url({{url('/')}}/images/library3.jpg);"></div>
</div>


<div id="about" class="container-fluid-body container-fluid container">
    <div class="text-center">
        <h1 class="display-4 logo mb-5">About Study+</h1>
        <p class="body_text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Placeat ullam tenetur architecto atque animi magnam quis veritatis dolor, voluptatem accusamus molestias deserunt veniam, sed odit debitis fugiat commodi iure, velit nihil voluptas. Earum consectetur facilis perspiciatis consequuntur aut tempore quia numquam, praesentium in aperiam iste accusamus suscipit ducimus cum commodi.§</p>
    </div>

    <div class="row profile_pic_holder container">
        <div class="col-sm-4">
            <div class="text-center">
                <p class="picture_name"><strong>Discuss</strong></p>
                <br>
                <img class="bandmember_pic shadow" src="{{url('/')}}/images/discuss.jpg" alt="">
            </div>
        </div>

        <div class="col-sm-4">
            <div class="text-center">
                <p class="picture_name"><strong>Study</strong></p>
                <br>
                <img class="bandmember_pic shadow" src="{{url('/')}}/images/main-bg.jpg" alt="">
            </div>
        </div>

        <div class="col-sm-4">
            <div class="text-center">
                <p class="picture_name"><strong>Compete</strong></p>
                <br>
                <div class="prof_picture_holder text-center">
                    <img class="bandmember_pic shadow" src="{{url('/')}}/images/compete.jpg" alt="">
                </div>
                
            </div>
        </div>

    </div>
</div>


<div id="contact" class="container-fluid-body container-fluid container mb-5">
    <div class="text-center">
        <h1 class="display-4 logo mb-5">Contact</h1>
    </div>

    <div class="row addPadding">
        <div class="col-md-4 mb-2">
            <p class="mb-3" style="color: #777;">Have any Questions? Drop us a note</p>

            <p class="contact_details">Guildford, UK</p>
            <p class="contact_details">Phone: +00 1515151515</p>
            <p class="contact_details">Email: study.plus013@gmail.com</p>
        </div>

        <div class="col-md-8">
            <form action="{{url('/sendEmail')}}" method="GET">
                <div class="row mb-3">
                    <div class="col-sm-6 form-group mb-3">
                    <input class="form-control" id="name" name="name" placeholder="Name" type="text" required>
                    </div>
                    <div class="col-sm-6 form-group mb-3">
                    <input class="form-control" id="email" name="email" placeholder="Email" type="email" required>
                    </div>
                </div>
                <textarea style="height: 100px; font-size: 13px;" name="message" class="form-control mb-3" id="comments"  placeholder="Message" rows="5" required></textarea>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <button type="submit" class="btn btn-dark pull-right" style="float: right;" type="submit">Send</button>
                    </div>
                </div> 
            </form>
        </div>

        <!-- <img src="{{url('/')}}/images/map.jpg" class="img-fluid" style="width: 100%;" alt="..."> -->


</div>
@endsection


