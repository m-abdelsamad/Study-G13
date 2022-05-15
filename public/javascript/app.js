

//Create chat
async function createChat(userId){

    var myId = ($('.auth-user').attr('id')).split('_');
    myId = parseInt(myId[1]);
    var participants = [myId, userId];
    console.log(participants);

    chat = await chatsCollection
    .where(`participants.${myId}`, "==", true)
    .where(`participants.${otherUserId}`, "==", true)
    .limit(1).get();
  
    if(!chat.exists){
       var chat_key = (Math.random() + 1).toString(36).substring(2);

       chatData = {
           key: chat_key,
           created_at: new Date(),
           participants: {
               myId: true,
               otherUserId: true,
           }
       }
       chatsCollection.doc(chat_key).set(chatData);
    
    } else {
       alert('chat exists')
    }

}
//end Create chat




//create group chat
function createGroupChat(){
    var myId = ($('.auth-user').attr('id')).split('_');
    myId = parseInt(myId[1]);

    const participants = [myId];
    var text = $('.chat-name-input').val()
    if($('.user_chat_card.group.selected').length >= 1 && (text)){
        
        $('.user_chat_card.group.selected').each(function(){
            var values = ($(this).attr('id')).split('_');
            var id = parseInt(values[1]);
            participants.push(id);
        });
    
        var chat_key = (Math.random() + 1).toString(36).substring(2);
        const chatData = {
            key: chat_key,
            name: $('.chat-name-input').val(),
            isGroupChat: true,
            participants: participants,
            created_at: new Date(),
        }
    
        chatsCollection.doc(chat_key).set(chatData);
        console.log('Group Chat created');

        $('.group-chats-back-btn').removeClass('active')
        $('.group_user_cards').removeClass('active')
        $('.search_tab').addClass('active')
        $('.chat_cards').addClass('active')

    } else {
        alert('Please select at least 1 participant in this chat and The name of the chat cant be empty')
    }
    
}
//end create group chat





// (() => {   
// })()


$(document).ready(function(){

    if($(".messenger")[0]){
        $('.navbar').addClass('hide')
    } else {
        $('.navbar').removeClass('hide')
    }
    
    
    $('.chat-back-btn').click(function(){
        $('.chat_cards').addClass('active');
        // $('.create-chat').addClass('active');
        $('.user_cards').removeClass('active');
        $('.search_tab').addClass('active');
        $(this).removeClass('active');
    });

    $('.group-chat-next').click(function(){
        $('.user_cards').removeClass('active');
        $('.chat-back-btn').removeClass('active');
        $('.group-chats-back-btn').addClass('active');
        $('.search_icon').removeClass('active');
        $('.group_user_cards').addClass('active');
    })

    $('.group-chats-back-btn').click(function(){
        $('.group_user_cards').removeClass('active');
        $('.chat_cards').addClass('active');
        $('.search_tab').addClass('active');
        $(this).removeClass('active')
    })

    $('.user_chat_card.group').click(function(){
        $(this).toggleClass('selected');
    });

    $('.user_chat_card.user').click(function(){
        var id = ($(this).attr('id')).split('_');
        createChat(parseInt(id[1]));
    })

    $('.create-group-chat-btn').click(function(){
        createGroupChat();
    })

    $('.create-reply-btn').click(function(event){
        event.preventDefault();
        $('.add_reply_section').addClass('active');
        $('.add_reply_inputs').addClass('active');
    })

    $('.close-reply-secection').click(function(event){
        event.preventDefault();
        $('.add_reply_section').removeClass('active');
        $('.add_reply_inputs').removeClass('active');
    })

});




//Get User from Firebase
function getOtherUser(id){
    return new Promise((resolve) => {
        usersCollection.where("id", "==", id).get()
        .then(function(querySnapshot) {
            querySnapshot.forEach(function(doc) {
                //console.log(doc.id, " => ", doc.data());
                resolve(doc.data());
            });
        });
    }); 
    
}
//end Get User from Firebase




//Display Chat Messages
const displayMessages =(messages, sender_id)=>{
    $('.messages_container ').html(""); 
    messages.forEach((msg)=> {
        let html = `
            <div class="text_holder ${msg.sender_id === sender_id? 'recieved': ''}">
				<div class="text shadow">
					<p>${msg.message}</p>
				</div>
				<div class="time">
					<p>${((msg.created_at).toDate()).toLocaleTimeString()}</p>
				</div>
			</div>
        `;
        $('.messages_container').append(html);  
    })
   
    var div = $('.messages_container');

    div.animate({
        scrollTop: div[0].scrollHeight
    }, 500);
    //$('.messages_container').scrollTop($('.messages_container')[0].scrollHeight);
}
//end Display Chat Messages

//Listen to added chats from firebase
if(document.getElementsByClassName('messenger')){

    chatsCollection.orderBy('created_at').onSnapshot((querySnapshot) => {
   
        $('.chat_cards').html('');
        $('.chat_cards').append('<div class="create-chat-btn shadow"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/></svg></div>')
    
        var myId = parseInt(($('.auth-user').attr('id').split('_'))[1]);
        // alert(myId)
        querySnapshot.forEach(async (doc) => {
            var data = doc.data();
            if(data.participants.includes(myId)){
                var html;
                if(!data.isGroupChat){
                    var otherId = data.participants.find(id => { id != myId });
                    var user = await getOtherUser(otherId);
                    
                    html = `
                        <div id="chat_${user.id}" class="chat_card shadow">
                            <div class="upper_section d-flex flex-row">
                                <div class="image upper_inner"></div>
                                <div class="user-chat-name upper_inner">
                                    <h4>${user.name}</h4>
                                    <p>Online</p>
                                </div>
                                <div class="text-sent-date upper_inner">
                                    <p>3h ago</p>
                                </div>
                            </div>
                            <div class="lower_section">
                                <p>Lorem ipsum dolor sit amet consectetur.</p>
                            </div>
                        </div>
                    `;
                } else {

                    html = `
                        <div id="chat_${data.key}" class="chat_card shadow">
                            <div class="upper_section d-flex flex-row">
                                <div class="image upper_inner"></div>
                                <div class="user-chat-name upper_inner">
                                    <h4 data-toggle="tooltip" title="${(data.name)}">${(data.name).length > 13 ? (data.name).substring(0, 12) + "...": (data.name)}</h4>
                                    <p>Group Chat</p>
                                </div>
                                <div class="text-sent-date upper_inner">
                                    <p></p>
                                </div>
                            </div>
                            <div class="lower_section">
                                <p></p>
                            </div>
                        </div>
                    `;
                }   

                $('.chat_cards').prepend(html);
                //html.show(1500) 
            }
        });


        //load chat messages
        $('.chat_card').click(function(){
            var values = ($(this).attr('id')).split('_');
            var chat_key = values[1];
            var myId = ($('.auth-user').attr('id')).split('_');

            var newID = `sendTo_${chat_key}`;    
            $('.send_message_btn').val(newID);

            var chat = chatsCollection.doc(chat_key).collection('msg');
            //$('.messages_header .chat-user-info h4').html()
            var nameOfChat = $(`#chat_${chat_key} .user-chat-name h4`).attr('title')
            $('.chat-user-info h4').html(nameOfChat)

            chat.orderBy('created_at').onSnapshot((querySnapshot) => {
                const messages = [];
                querySnapshot.forEach((doc) => {
                    messages.push(doc.data());
                });
                displayMessages(messages, myId[1]);
            })
        })
        //end load chat messages
        
        $('.create-chat-btn').click(function(){
            $('.chat_cards').removeClass('active');
            $('.group_user_cards').addClass('active');
            $('.search_tab').removeClass('active');
            $('.group-chats-back-btn').addClass('active');
        });


    })
}
//end Listen to added chats from firebase





//Send message
$(document).ready(function(){
    $('.send_message_btn').click(function(event){
        event.preventDefault();
        //alert('clicked');
    
        var values = ($(this).val()).split('_');
        var myId = ($('.auth-user').attr('id')).split('_');
        var message = $('.message_input').val();

        //alert(`${values} / ${myId} / ${message}`)
    
    
        if(message){
            const data = {
                "sender_id": myId[1],
                "message": message,
                "created_at": new Date(),
            }
            var chat = chatsCollection.doc(values[1]).collection('msg');
            chat.add(data);
            Object.assign(data, {'key':values[1]}); 

            //$(`#chat_${values[1]} .lower_section p`).html(message)
    
            // $.ajax({
            //     type:"POST",
            //     url: `${url}/sendMessage`,
            //     dataType:"json",
            //     headers: {
            //         'X-CSRF-Token': csrf_token, 
            //     },
            //     data: data,
            //     success: function(){
            //         console.log('message saved');
            //         $('.message-input').val("");
    
            //     }
            // });  
            $('.message_input ').val("");               
        }    
    });
    //end Send message
})



// tinymce
// for text area
// tinymce.init({
//     selector: 'input.reply-text-area', 
// });




// submitting post
$(document).ready(function(){
    $('.add-post-btn').click(function(event){
        event.preventDefault()

        if($('#postFrom').valid()){
            post_description = $('.post_description').val();
            post_title = $('.post_title').val();

            $.ajax({
                type: "POST",
                url: `${url}/discussionBoard/store`,
                dataType: "json",
                headers: {
                    'X-CSRF-Token': csrf_token, 
                },
                data: {
                    post_title: post_title,
                    post_description: post_description,
                },
                success: function(response){
                    
                    html = `
                    <div class="col-lg-12 col-sm-12">
                        <div class="question_card bg-light shadow">
                            <div class="replies_box">
                                <p>0</p>
                                <svg data-toggle="tooltip" title="replies" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-reply" viewBox="0 0 16 16">
                                    <path d="M6.598 5.013a.144.144 0 0 1 .202.134V6.3a.5.5 0 0 0 .5.5c.667 0 2.013.005 3.3.822.984.624 1.99 1.76 2.595 3.876-1.02-.983-2.185-1.516-3.205-1.799a8.74 8.74 0 0 0-1.921-.306 7.404 7.404 0 0 0-.798.008h-.013l-.005.001h-.001L7.3 9.9l-.05-.498a.5.5 0 0 0-.45.498v1.153c0 .108-.11.176-.202.134L2.614 8.254a.503.503 0 0 0-.042-.028.147.147 0 0 1 0-.252.499.499 0 0 0 .042-.028l3.984-2.933zM7.8 10.386c.068 0 .143.003.223.006.434.02 1.034.086 1.7.271 1.326.368 2.896 1.202 3.94 3.08a.5.5 0 0 0 .933-.305c-.464-3.71-1.886-5.662-3.46-6.66-1.245-.79-2.527-.942-3.336-.971v-.66a1.144 1.144 0 0 0-1.767-.96l-3.994 2.94a1.147 1.147 0 0 0 0 1.946l3.994 2.94a1.144 1.144 0 0 0 1.767-.96v-.667z"/>
                                </svg>
                                
                            </div>
                            <div>
                                <button class="btn delete-post-btn">Delete</button>
                            </div>
                            <a href="${url}/discussionBoard/${response.post.id}" class="question_title">${response.post.title}</a>
                            <div class="owner_details">
                                <div class="user_picture shadow">
                                    <img src="${url}/images/prof_pic.jpg" style="width: 100%; height: 100%; border-radius: 11px;" alt="">
                                </div>
                                <div class="user_info">
                                    <h4>${response.user.name}</h4>
                                    <p>${response.post.created_at}</p>
                                </div>
                            </div>
                            <p class="question_text">${response.post.description}</p>
                            <!-- <p class="question_text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Iure aperiam pariatur officiis unde dolorem debitis perferendis sint rem ut dolorum! Officiis rerum iste architecto nesciunt maiores beatae repellat sequi amet?</p> -->
                        </div>
                    </div>`;

                    $('.question_cards_holder').append(html);
                    $('.post_description').val('');
                    $('.post_title').val('');

                    $('.add_reply_section ').removeClass('active');
                    $('.add_reply_inputs  ').removeClass('active');

                },
                error: function(xhr, textStatus, thrownError) {
                    // $("#error").append(`
                    // <div class="alert alert-danger mt-2" role="alert">
                    //     <li> ${xhr.responseJSON.message}</li>
                    // </div>
                    // `)
                },
            })
        }
    })



    $('.add-reply-btn').click(function(event){
        event.preventDefault();

        reply_content = $('.reply_content').val();
        if($('#addReplyForm').valid()){

            post_id = (($('.question_section').attr('id')).split('_'))[1];
            
            $.ajax({
                type: "POST",
                url: `${url}/discussionBoard/${post_id}/addReply`,
                dataType: "json",
                headers: {
                    'X-CSRF-Token': csrf_token, 
                },
                data: {
                    reply_content: reply_content,
                },

                success: function(response){
                    html = `
                        <div id="reply_${response.reply.id}_${response.reply.post_id}" class="reply_holder col-lg-12 col-sm-12 mb-3">
                            <div class="reply bg-light shadow">
                                <h4>From ~ ${response.user.name}</h4>
                                <p>${response.reply.content}</p>
                            </div>
                        </div>
                    `

                    var replies = parseInt($('.replies_box p').text()) + 1;
                    $('.replies_box p').html(replies);
                    $('.reply_content').val('')
                    $('.replies').append(html);

                }
            });
        }

    })
})




//Pomodoro Timer
let interval;

function submitStudySession(totalSeconds){
    $.ajax({
        type: "POST",
        url: `${url}/timer/submitStudySession`,
        dataType: "json",
        headers: {
            'X-CSRF-Token': csrf_token, 
        },
        data: {
            totalSeconds: totalSeconds,
        },
        success: function(response){
            if(response.status == 200){
                $('.sec').html("00")
                $('.min').html("00")
                $('.hour').html("00")

                hours = (totalSeconds/60)/60
                if(hours > 1){
                    hours = `${hours} hours`
                } else {
                    hours = `${hours} hour`
                }
                $('#exampleModal .modal-body').html(`Your study session of ${hours} has been submitted`)
                $('#exampleModal').modal('show');
            }
             
        }
    })
}

function countDown(totalSeconds, intervalType){
    var seconds = 0;
    var currentSeconds = 0;
    var timmer_section = document.getElementsByClassName('timmer_section');

    $('body').css({
        "background":"#20fc867d",
    })
    
    interval = setInterval(function() {
        var second = ($('.sec').text());
        var minute = ($('.min').text());
        var hour = ($('.hour').text());


        if(second === "00" && minute === "00"){
            hour = parseInt(hour);
            hour-=1
            if(hour < 10){
                hour = `0${hour}`
            }
            minute = "59"
            second = "59"
        } else if(second === "00" && minute != "00"){
            minute = parseInt(minute);
            minute-=1
            if(minute < 10){
                minute = `0${minute}`
            }
            second = "59"
        } else{
            second = parseInt(second)
            second-=1
            if(second < 10){
                second = `0${second}`
            }
        }

        $('.sec').html(second)
        $('.min').html(minute)
        $('.hour').html(hour)

        seconds++;

        if(seconds == 1500 && intervalType == "study"){
            seconds = 0
            intervalType = "break"
            $('.clock_holder').css({
                "border-color":"tomato",
            })
            $('.timmer_section .inputs .time_select').css({
                "border-color":"tomato",
            })
            $('.timmer_section .inputs .select_time_btn').css({
                "border-color":"tomato",
            })
            $('body').css({
                "background":"#ff2700b5",
            })
            
            timmer_section.innerHTML = ".timmer_section:before {content: 'Break';}";

        } else if(seconds == 300 && intervalType == "break"){
            seconds = 0
            intervalType = "study"
            $('.clock_holder').css({
                "border-color":"#00fc75",
            })
            $('.timmer_section .inputs .time_select').css({
                "border-color":"#00fc75",
            })
            $('.timmer_section .inputs .select_time_btn').css({
                "border-color":"#00fc75",
            })
            

            $('body').css({
                "background":"#20fc867d",
            })
            timmer_section.innerHTML = ".timmer_section:before {content: 'Study';}";

        }

        if((second === "00" && minute === "00" && hour === "00")){
            // alert('time is up');
            $('body').css({
                "background":"white",
            })
            clearInterval(interval);
            submitStudySession(totalSeconds)
        }

    }, 1)

    
}

function timmer(hour){

    if(hour < 10){
        html = `0${hour}`
    } else {
        html = hour
    }
    $('.hour').html(html);
    
    seconds = hour * 60 *60;
    countDown(seconds, "study");

}


$(document).ready(function(){
    $('.select_time_btn').click(function(event){
        event.preventDefault()
        if(interval){
            clearInterval(interval);
            $('.sec').html("00")
            $('.min').html("00")
            $('.hour').html("00")

            $('.clock_holder').css({
                "border-color":"#00fc75",
            })
        }
        

        if($('#timerForm').valid()){
            time = parseInt($('.time_select').val())
            timmer(time);
        }
        
    });
})
//Pomodoro Timer


// contact us form
const validateContactForm = function(){
    $('#contact_form').validate({
        rules: {
            'name': {required: true},
            'email': {
                required: true,
                email: true,
            },
            'message': {
                required: true,
                minlength: 10,
            }
        },
        messages: {
            'name': {required: "name is required",},
            'email': {
                required: "email is required",
                email: "incorrect email format",
            },
            'message': {
                required: "message is required",
                minlength: "must have at least 10 characters"
            }
        }
    })
}

$(document).ready(function(){
    if(document.getElementById('contact_form')){
        validateContactForm();
    }

    // $('.send_email_btn').click(function(event){
    //     event.preventDefault();
    //     validateContactForm();

    //     if($('#contact_form').valid()){
    //         alert('valid')
    //     }
    // })
})
//contact us form

// $('.header_link').click(function(event){
//     id = $(this).attr('id')
//     $(`#${id}`).addClass('active-link')
// });

$(document).ready(function(){

    $('#overview_link').click(function(event){
        event.preventDefault();
        $(this).addClass('active-link');
        $('#edit_prof_link').removeClass('active-link');

        $('.prof_details_section').removeClass('hide');
        $('.edit-prof-details').addClass('hide');

    })


    $('#edit_prof_link').click(function(event){
        event.preventDefault();
        $(this).addClass('active-link');
        $('#overview_link').removeClass('active-link');

        $('.prof_details_section').addClass('hide');
        $('.edit-prof-details').removeClass('hide');

    })

    
    // $('.edit-prof-submit-btn').click(function(event){
    //     event.preventDefault();

    //     var name = $('.user_name_edit').val();
    //     var email = $('.email_edit').val();
    //     var uni_name = $('.uni_name_edit').val();
    //     var day_hr = $('.day_hrs_edit').val();
    //     var week_hr = $('.week_hrs_edit').val();

    //     if($('#edit_details_form').valid() && name && email && uni_name && day_hr && week_hr){
            

    //         $.ajax({
    //             type: "POST",
    //             url: `${url}/dashboard/updateDetails`,
    //             dataType: "json",
    //             headers: {
    //                 'X-CSRF-Token': csrf_token, 
    //             },
    //             data: {
    //                 name: name,
    //                 email: email,
    //                 uni_name: uni_name,
    //                 day_hr: (day_hr*60*60),
    //                 week_hr: (week_hr*60*60),
    //             }, 
    //             success: function(response){
    //                 if(response.status == 200){
    //                     $('.user_name').html(name)
    //                     $('.user_email').html(email)
    //                     $('.user_uni').html(uni_name)
                        
    //                     $('.user_day_hr').html(day_hr)
    //                     $('.user_week_hr').html(week_hr)

    //                     $('#overview_link').addClass('active-link');
    //                     $('#edit_prof_link').removeClass('active-link');

    //                     $('.prof_details_section').removeClass('hide');
    //                     $('.edit-prof-details').addClass('hide');
    //                 }
                    
    //             }
    //         });
    //     }

        

    // })


});




$(document).ready(function(){
    $('.delete-post-btn').click(function(event){
        event.preventDefault();
        var post_id = (($(this).closest('.question_card')).attr('id')).split('_');
        post_id = post_id[1];
        $.ajax({
            type: "POST",
            url: `${url}/discussionBoard/deletePost/${post_id}`,
            dataType: "json",
            headers: {
                'X-CSRF-Token': csrf_token, 
            },
            data: {
            }, 
            success: function(response){
                if(response.status == 200){
                    $(`#post_${post_id}`).fadeOut(100);
                }
          
            }
        });

    });
});





// async function testFunction(){
//     var user = await getOtherUser(4);
//     console.log('user', user);
//     console.log('hereeeeeeeeeee')
// }
// testFunction();


// usersCollection.doc('KKQOUJ7gYeeiLEk').get().then((doc) => {
//     // Document was found in the cache. If no cached document exists,
//     // an error will be returned to the 'catch' block below.
//     console.log("Cached document data:", doc.data());
// }).catch((error) => {
//     console.log("Error getting cached document:", error);
// });








//create chat section
// var chat = await chatsCollection.where('participants', 'in', [myId]).where('participants', 'in', [userId]).limit(1).get();

    // if (chat.exists) {
    //     console.log("Document data:", chat.data());
    // } else {
    //     console.log("No such document!");
    // }

    // chatsCollection.where('participants', 'array-contains', participants).limit(1).get().then((doc) => {
    //     if (doc.exists) {
    //         console.log("Document data:", doc.data());
    //     } else {
    //         console.log("No such document!");
    //     }
    // })


    //if(!chat){
        //alert('no chat');
        // var chat_key = (Math.random() + 1).toString(36).substring(2);
        // messagesCollection.doc(chat_key).set({"created_at": new Date(), "participants": participants });
    
        // $.ajax({
        //     method: 'POST',
        //     url: `${url}/createChat`,
        //     dataType:"json",
        //     headers: {
        //         'X-CSRF-Token': csrf_token, 
        //     },
        //     data: { 
        //         chat_key: chat_key,
        //         participants: participants, 
        //     },
        //     success: function(response){
        //         console.log('chat added');

        //         $('.chats').addClass('active');
        //         $('.create-chat').addClass('active');
        //         $('.users').removeClass('active');
        //         $('.chats-back-btn').removeClass('active');
        //     }
        // })
    // } else {
    //     alert('chat already exists');
    // }



    // $.ajax({
    //     method: 'POST',
    //     url: `${url}/createChat`,
    //     dataType:"json",
    //     headers: {
    //         'X-CSRF-Token': csrf_token, 
    //     },
    //     data: { 
    //         participants: participants, 
    //     },
    //     success: function(response){
    //         // if(response.chatExists){
    //         //     alert('chat exists');
    //         // } else {
    //         //     var chat = response.chat;
    //         //     chatsCollection.doc(chat.key).set({"created_at": new Date(), "participants": participants });

    //         //     console.log('chat added');

    //         //     $('.chats').addClass('active');
    //         //     $('.create-chat').addClass('active');
    //         //     $('.users').removeClass('active');
    //         //     $('.chats-back-btn').removeClass('active');
    //         // }
    //     }
    // })