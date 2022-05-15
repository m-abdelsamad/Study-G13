@extends('layouts.master')
@section('body')

<div class="timmer_section " style="">
    <div class="clock_holder shadow">
        <div class="hour">00</div>
        <div>:</div>
        <div class="min">00</div>
        <div>:</div>
        <div class="sec">00</div>
    </div>
    <div class="inputs">
        <form action="" id="timerForm">
            <div class="select_time d-flex align-items-center justify-content-center flex-column">
                <select class="form-select time_select mb-1" aria-label="Default select example" required>
                    <option selected value="">Time</option>
                    <option value="1">1 hr</option>
                    <option value="2">2 hrs</option>
                    <option value="3">3 hrs</option>
                    <option value="4">4 hrs</option>
                    <option value="5">5 hrs</option>
                    <option value="6">6 hrs</option>
                    <option value="7">7 hrs</option>
                    <option value="8">8 hrs</option>
                    <option value="9">9 hrs</option>
                    <option value="10">10 hrs</option>
                </select>
            </div>

            <div class="select_time_btn_holder d-flex align-items-center justify-content-center">
                <button class="btn select_time_btn">GO</button>
            </div>
        </form>
    </div>
</div>
<!-- <p class="text-center mt-5">Once the Timmer starts, it will swictch between 25 mins of studying time and 5 mins of break</p> -->


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Alert From Page</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p></p>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>

    

@endsection