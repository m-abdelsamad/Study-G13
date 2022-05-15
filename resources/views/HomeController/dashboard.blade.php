@extends('layouts.master')
@section('body')
<div class="container dashboard_section">
    <h1 class="display-5 mt-5 mb-5">Dashboard</h1>

    <div class="user_details mx-auto mt-5">
        <div class="row">
            <div class="col-lg-4 col-sm-12 mb-5 d-flex justify-content-cetner">
                <!-- 06 lc 02 -->
                <div class="left_side_details bg-light shadow">
                    <div class="img-holder shadow">
                        <img src="{{url('/')}}/images/prof_pic.jpg" style="width: 100%; height: 100%; border-radius: 50%;" alt="">
                    </div>
                    <h4 class="user_name">{{auth()->user()->name}}</h4>
                    <form method="POST" action="{{url('/deleteAccount')}}" >
                        @csrf
                        <button class="btn theme-btn mt-3 shadow">Delete Account</button>
                    </form>
                </div>

            </div>

            <div class="col-lg-8 col-sm-12 mb-5 d-flex align-items-center justify-content-cetner">
                <!--  -->
                <div class="right_side_details bg-light shadow">
                    <nav class="section_header">
                        <a href="" id="overview_link" class="header_link  active-link">Overview</a>
                        <a href="" id="edit_prof_link" class="header_link ">Edit Profile</a>
                    </nav>


                    <div class="prof_details_section prof_details">
                        <!-- <h4>About</h4>
                        <p class="about">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Neque, temporibus consequuntur reiciendis sit aspernatur nulla nostrum laudantium mollitia architecto corrupti!</p> -->

                        <h4>Profile Details</h4>
                        <div class="row">
                            <div class="col-3 left_side">
                                <p>Full Name</p>
                                <p>Email Address</p>
                                <p>University Name</p>
                            </div>
                            <div class="col-3 right_side">
                                <p class="user_name">{{auth()->user()->name}}</p>
                                <p class="user_email">{{auth()->user()->email}}</p>
                                <p class="user_uni">{{auth()->user()->university_name}}</p>
                            </div>
                        </div>

                        <h4>Studying Goals</h4>
                        <div class="row">
                            <div class="col-3 left_side">
                                <p>Hours Per Day</p>
                                <p>Hours Per Week</p>
                            </div>
                            <div class="col-3 right_side">
                                <p class="user_day_hr">{{(auth()->user()->hrs_per_day/60)/60}}</p>
                                <p class="user_week_hr">{{((auth()->user()->hrs_per_week/60)/60)}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="prof_details edit-prof-details hide">
                        <!--  -->
                        <form action="{{url('/dashboard')}}" method="POST" id="edit_details_form">
                            @csrf
                            <h4>Edit Profile Details</h4>
                            <div class="row">
                                <div class="col-3 left_side">
                                    <p class="mb-4" style="margin-top: 10px;">Full Name</p>
                                    <p class="mb-4" style="margin-top: 10px;">Email Address</p>
                                    <p class="mb-4" style="margin-top: 10px;">University Name</p>
                                </div>
                                <div class="col-3 right_side">
                                    <input type="text" name="name" class="form-control mb-2 user_name_edit" value="{{auth()->user()->name}}" required>
                                    <input type="email" name="email" class="form-control mb-2 email_edit"  value="{{auth()->user()->email}}" required>
                                    <input type="text" name="uni_name" class="form-control mb-2 uni_name_edit" value="{{auth()->user()->university_name}}" required>

                                </div>
                            </div>

                            <h4 class="mt-3">Studying Goals</h4>
                            <div class="row">
                                <div class="col-3 left_side">
                                    <p class="mb-4" style="margin-top: 10px;">Hours Per Day</p>
                                    <p class="mb-4" style="margin-top: 10px;">Hours Per Week</p>
                                </div>
                                <div class="col-3 right_side">
                                    <input type="number" name="hrs_per_day" min="1" max="24" class="form-control mb-2 day_hrs_edit"  value="{{(auth()->user()->hrs_per_day/60)/60}}" required>
                                    <input type="number" name="hrs_per_week" min="24" max="168" class="form-control mb-2 week_hrs_edit"  value="{{((auth()->user()->hrs_per_week/60)/60)}}" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-dark edit-prof-submit-btn">Save Changes</button>
                        </form>
                        <!--  -->
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="hours_of_day mt-5 mb-5">
        <h1 class="display-5 mb-5">Hours Studied Today</h1>
        <div class="row">
            <div class="col-lg-6 col-sm-12 mb-5 d-flex align-items-center justify-content-center" value="" style="padding: 10px 20px;">
                <div class="per_week bg-light shadow">
                    <h5 class="text-center">Hours Per Week</h5>
                    <canvas id="weekHours"></canvas>
                </div>
                
            </div>

            <div class="col-lg-6 col-sm-12 mb-5 d-flex align-items-center justify-content-center" style="padding: 10px 20px;">
                <div class="per_day bg-light shadow">
                    <h5 class="text-center">Hours Per Day</h5>
                    <canvas id="dayHours"></canvas>
                </div>
                
            </div>
        </div>    
    </div>
    
    <div class="leaderboard_section mt-5 mb-5 row">
        <h1 class="mt-5 display-5">Leaderboard</h1>
        @if($studySessions->count() > 0)
        <div class="col-sm-12 d-flex align-items-center justify-content-center">
            <div class="bg-light shadow leaderboard_holder">
                <canvas id="myChart"></canvas>
            </div>
        </div>
        
     
        @else
        <h4 class="text-center mt-5" style="margin-bottom: 150px;">No Study Sessions have been submitted yet, Go over to the Study timer and start a new study session</h4>
        @endif
    </div>

</div>



<script>
const users = @json($users);
const studySessions = @json($studySessions);

const todaysHoursObject = @json($studySession);
let todaysHours;
if(todaysHoursObject != null){
    todaysHours= (todaysHoursObject.time/60)/60;
} else {
    todaysHours= 0
}
console.log(todaysHoursObject);


const weeksHoursObject = @json($myWeekSession);
let weeksHours = 0;
for(let i=0; i< weeksHoursObject.length; i++){
    weeksHours += weeksHoursObject[i].time;
}
weeksHours = (weeksHours/60)/60;

let dayGoal = parseInt($('.user_day_hr').text())
dayGoal = dayGoal;

let weekGoal = parseInt($('.user_week_hr').text())
weekGoal = weekGoal;

let labels = []
let studySessionData = [];
let leaderBoardLength = 0;

for(let i=0; i< studySessions.length; i++){
    for(let j=0; j< users.length; j++){
        if((users[j].id == studySessions[i].user_id) && leaderBoardLength <10){
            var prev;
            var prevIndex;
            labels.find(function (element, index){
                // e => e.id == users[j].id
                if(element.id == users[j].id){
                    prev = element;
                    prevIndex = index;
                }
            });
            if(prev){
                console.log(prev);
                console.log(studySessionData[prevIndex])
                hours = (studySessions[i].time/60)/60;
                studySessionData[prevIndex] += hours;
            } else {
                labels.push({id: users[j].id, name: users[j].name});
                hours = (studySessions[i].time/60)/60;
                studySessionData.push(hours);
                leaderBoardLength++;
            }
            
        }
    }
}

labels = labels.map(element => element.name);
// studySessionData.sort()

if(labels.length > 0){
    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'bar',
        options: {
            indexAxis: 'y',
            plugins: {
                title: {
                    display: true,
                    text: `Top 10 students`,
                }
            },
            scales: {
                y: {
                    suggestedMin: 0,
                    suggestedMax: 50
                }
            }
        },
        data: {
            //user names
            labels: labels,
            datasets: [{
                label: '# of hours',
                //number of hours
                data: studySessionData,
                backgroundColor: [
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    
                ],
                borderColor: [
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    
                ],
                borderWidth: 1
            }]
        },
        
    });
}



const ctx1 = document.getElementById('weekHours').getContext('2d');
const myChart1 = new Chart(ctx1, {
    type: 'doughnut',
    options: {
        scales: {
            yAxes: [{
                display: false
            }],
        }
    },
    data: {
        //user names
        labels: ((weekGoal - weeksHours)) > 0? ["Study Hours Goal", "Remaining Hours"] : ["Study Hours Goal", "Study Hour Goal is met"],
        datasets: [{
            label: '# of hours',
            //number of hours
            data: [weekGoal, ((weekGoal - weeksHours)) > 0? (weekGoal - weeksHours) : 'Goal is met'],
            backgroundColor: [
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                
                'rgba(54, 162, 235, 0.2)',
                
            ],
            borderColor: [
                'rgba(255, 159, 64, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                
                'rgba(54, 162, 235, 1)',
                
            ],
            borderWidth: 1
        }]
    },
    y: {
        display: false,
    },
});


const ctx2 = document.getElementById('dayHours').getContext('2d');
const myChart2 = new Chart(ctx2, {
    type: 'doughnut',
    options: {
        scales: {
            yAxes: [{
                display: false
            }],
        }
    },
    data: {
        //user names
        labels: ((dayGoal - todaysHours)) > 0? ["Study Hours Goal", "Remaining Hours"] : ["Study Hours Goal", "Study Hour Goal is met"],
        datasets: [{
            label: '# of hours',
            //number of hours
            data: [dayGoal, ((dayGoal - todaysHours)) > 0? (dayGoal - todaysHours) : '0'],
            backgroundColor: [
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                
            ],
            borderColor: [
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                
            ],
            borderWidth: 1
        }]
    },
    
});

</script>
@endsection