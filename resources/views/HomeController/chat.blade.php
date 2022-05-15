@extends('layouts.master')
@section('body')
<div class="messenger auth-user" id="auth_{{auth()->user()->id}}">

	<div class="chats_section">
		<div class="search_bar">
			<div>
				<!-- <input type="text" placeholder="Search" class="search_input shadow">
				<span class="search_icon">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
						<path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
					</svg>
				</span> -->
				<!-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
					<path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
				</svg>
				<a href="{{url('/dashboard')}}">Dashboard</a> -->
			</div>
			<a class="btn search_tab active shadow" href="{{url('/dashboard')}}">Dashboard</a>

			<div class="chat-back-btn shadow">
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
					<path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
				</svg>
				<h1>Back</h1>
			</div>

			<div class="group-chats-back-btn shadow">
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
					<path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
				</svg>
				<h1>Back</h1>
			</div>

		</div>

		<div class="lower_part">
			<!--  -->
			<div class="chat_cards active">
		
			</div>

			<div class="user_cards">
				<div class="user_chat_card shadow group-chat-next justify-content-center">
					<h1 class="">Create Group Chat</h1>
				</div>

				@foreach ($users as $user)
					<div id="user_{{$user->id}}" class="user_chat_card user shadow">
						<div class="image_holder shadow" style="background-color: black;">
						</div>
						<div class="user_info">
							<h1>{{$user->name}}</h1>
						</div>
					</div>
				@endforeach
			</div>

			<div class="group_user_cards">
				<div class="create-group-chat-btn shadow">
					<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
						<path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z"/>
						<path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
					</svg>
				</div>

				<div class="d-flex align-items-center justify-content-center">
					<input class="chat-name-input" type="text" placeholder="Chat Name">
				</div>

				@foreach ($users as $user)
					<div id="user_{{$user->id}}" class="user_chat_card group shadow">
						<div class="tick_svg">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
								<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
								<path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
							</svg>
						</div>	
					
						<div class="image_holder shadow" style="background-color: black;">
						</div>
						<div class="user_info">
							<h1>{{$user->name}}</h1>
						</div>
					</div>
				@endforeach		
			</div>
			<!--  -->
		</div>
	</div>

	<div class="messages_section">

		<div class="messages_header">
			<div class="image"></div>
			<div class="chat-user-info">
				<h4>Chat Name</h4>
				<p>Group Chat</p>
			</div>
		</div>

		<div class="messages_container">

		</div>

		<div class="message_input_box shadow">
			<input class="message_input" type="text">
			<button type="submit" class="send_message_btn">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
						<path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"/>
					</svg>
			</button>
		</div>

	</div>
</div>
@endsection
