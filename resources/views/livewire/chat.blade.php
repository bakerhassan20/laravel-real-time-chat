
<div wire:poll>
<div class="container">
<div class="row">
    <div class="col-lg-4">
    			<div class="tab-content"style="padding:20px">
						<div class="tab-panes" id="side">
							<div class="list-group list-group-flush ">
                              <!--stsrt user info and photo -->
                            @foreach ($users as $user)
                              	<div class="list-group-item d-flex  align-items-center">
									<div class="ml-2">
										<span class="avatar avatar-md brround cover-image"><img class="avatar avatar-md brround cover-image"src="{{ URL::asset('User_image/'.$user->image) }}"><span class="avatar-status bg-success"></span></span>
									</div>
									<div class="">
										<div class="font-weight-semibold" data-toggle="modal" data-target="#chatmodel">{{ $user->name }}</div>
									</div>
									<div class="mr-auto">
                                    <button wire:click="addTodo({{$user->id}})"class="btn btn-sm btn-light">
                                    <i class="fab fa-facebook-messenger"></i>
                                    </button>
									</div>
								</div>
                            @endforeach
                            <!--stsrt groub icon and photo -->

                            <!--stsrt groub info and photo -->
                              	<div class="list-group-item d-flex  align-items-center">
									<div class="ml-2">
										<span class="avatar avatar-md brround cover-image"><img class="avatar avatar-md brround cover-image"src="{{ URL::asset('User_image/OIP.jfif') }}"><span class="avatar-status bg-success"></span></span>

									</div>
									<div class="">
										<div class="font-weight-semibold" data-toggle="modal" data-target="#chatmodel">Groub</div>
									</div>
									<div class="mr-auto">
                                    <button wire:click="addTodo(100)"class="btn btn-sm btn-light">
                                    <i class="fab fa-facebook-messenger"></i>
                                    </button>
									</div>

								</div>
                            <!--stsrt groub info and photo -->
							</div>
						</div>
					</div>
    </div>


       <div class="col-lg-8">



<!-- Message Modal -->

		<div class="modal-dialogs modal-dialog-right chatbox" role="document"style="width:550px;padding-top:15px">
				<div class="modal-content chat border-0">


                   <div class="card overflow-hidden mb-0 border-0" style="max-height:570px;">

			        <!-- action-header -->
						<div class="action-header clearfix">
							<div class="float-left hidden-xs d-flex ml-2">
								<div class="img_cont mr-3">
                                    @if($user_info != null)
									<img src="{{URL::asset('User_image/'.$user_info->image)}}" class="rounded-circle user_img" alt="img">
                                    @else
                                    <img src="{{URL::asset('User_image/OIP.jfif')}}" class="rounded-circle user_img" alt="img">
                                    @endif
								</div>
								<div class="align-items-center mt-2">
							<h4 class="text-white mb-0 font-weight-semibold "id="section_name">
                            @if($user_info != null)
                            {{ $user_info->name }}
                            @else
                            Group
                            @endif
                            </h4>
									<span class="dot-label bg-success"></span><span class="mr-3 text-white">online</span>
								</div>
							</div>
							<ul class="ah-actions actions align-items-center">
								<li class="call-icon">
									<a href="" class="d-done d-md-block phone-button" data-toggle="modal" data-target="#audiomodal">
										<i class="si si-phone"></i>
									</a>
								</li>
								<li class="video-icon">
									<a href="" class="d-done d-md-block phone-button" data-toggle="modal" data-target="#videomodal">
										<i class="si si-camrecorder"></i>
									</a>
								</li>
								<li class="dropdown">
									<a href="" data-toggle="dropdown" aria-expanded="true">
										<i class="si si-options-vertical"></i>
									</a>
									<ul class="dropdown-menu dropdown-menu-right">
										<li><i class="fa fa-user-circle"></i> View profile</li>
										<li><i class="fa fa-users"></i>Add friends</li>
										<li><i class="fa fa-plus"></i> Add to group</li>
										<li><i class="fa fa-ban"></i> Block</li>
									</ul>
								</li>

							</ul>
						</div>
						<!-- action-header end -->
						<!-- msg_card_body -->

						<div class="card-body msg_card_body" id="chat">
                        <div class="chat">

							<div class="chat-box-single-line">
								<abbr class="timestamp">February 1st, 2022</abbr>
							</div>

					    @forelse ($messages as $message)
                        @if ($message->user_id_send == auth()->user()->id || $message->user_id == auth()->user()->id)
							<div class="d-flex justify-content-start">
								<div class="img_cont_msg">

									<img src="{{URL::asset('User_image/'.auth()->user()->image)}}" class="rounded-circle user_img_msg" alt="img">
								</div>
								<div class="msg_cotainer">
									{{ $message->message_text }}
									<span class="msg_time"></span>
								</div>
							</div>

						@else
							<div class="d-flex justify-content-end ">
								<div class="msg_cotainer_send">
									{{ $message->message_text }}
									<span class="msg_time_send"></span>
								</div>
								<div class="img_cont_msg">
                                @if($user_info != null)
									<img src="{{URL::asset('User_image/'.$user_info->image)}}" class="rounded-circle user_img_msg" alt="img">
                                @else
                                <img src="{{URL::asset('User_image/'.$message->user->image)}}" class="rounded-circle user_img_msg" alt="img">
                                @endif
								</div>
							</div>
                        @endif



                        @empty
                            <h5 style="text-align: center;color:red"> لاتوجد رسائل سابقة</h5>
                        @endforelse
						</div>
                        </div>
						<!-- msg_card_body end -->


						<!-- card-footer -->
						<div class="card-footer">
							<div class="msb-reply d-flex">
								<div class="input-group" style="display: inline !important;">
                            @if($user_info != null)
                                <form wire:submit.prevent="sendMessage">
                                <div class="row">
                                   <div class="col-10">
	                           <input type="text" class="form-control" placeholder="Typing...."
                                    onkeydown='scrollDown()' wire:model.defer="messageText"required>
                                </div>
                                 <div class="col-1" style="">

								<button type="submit"onclick='scrollDown()' class="btn btn-primary ">
											<i class="far fa-paper-plane" aria-hidden="true"></i>
								</button>

                                </div>
                                </div>
                                </form>
                            @else
                                <form wire:submit.prevent="sendGroupMessage">
                                <div class="row">
                                   <div class="col-10">
	                           <input type="text" class="form-control" placeholder="Typing...."
                                    onkeydown='scrollDown()' wire:model.defer="messageText"required>
                                </div>
                                 <div class="col-1" style="">

								<button type="submit"onclick='scrollDown()' class="btn btn-primary ">
											<i class="far fa-paper-plane" aria-hidden="true"></i>
								</button>

                                </div>
                                </div>
                                </form>
                            @endif

                            </div>
                        </div>
                       </div>
                        <!-- card-footer end -->
                               </div>
			               </div>


                     </div>
				</div>
      </div>
</div>
</div>
</div>


<!--Video Modal -->
		<div id="videomodal" class="modal fade">
			<div class="modal-dialog" role="document">
				<div class="modal-content bg-dark border-0 text-white">
					<div class="modal-body mx-auto text-center p-7">
						<h5>Valex Video call</h5>
						<img src="{{URL::asset('assets/img/faces/6.jpg')}}" class="rounded-circle user-img-circle h-8 w-8 mt-4 mb-3" alt="img">
						<h4 class="mb-1 font-weight-semibold">Daneil Scott</h4>
						<h6>Calling...</h6>
						<div class="mt-5">
							<div class="row">
								<div class="col-4">
									<a class="icon icon-shape rounded-circle mb-0 mr-3" href="#">
										<i class="fas fa-video-slash"></i>
									</a>
								</div>
								<div class="col-4">
									<a class="icon icon-shape rounded-circle text-white mb-0 mr-3" href="#" data-dismiss="modal" aria-label="Close">
										<i class="fas fa-phone bg-danger text-white"></i>
									</a>
								</div>
								<div class="col-4">
									<a class="icon icon-shape rounded-circle mb-0 mr-3" href="#">
										<i class="fas fa-microphone-slash"></i>
									</a>
								</div>
							</div>
						</div>
					</div><!-- modal-body -->
				</div>
			</div><!-- modal-dialog -->
		</div><!-- modal -->

		<!-- Audio Modal -->
		<div id="audiomodal" class="modal fade">
			<div class="modal-dialog" role="document">
				<div class="modal-content border-0">
					<div class="modal-body mx-auto text-center p-7">
						<h5>Valex Voice call</h5>
						<img src="{{URL::asset('assets/img/faces/6.jpg')}}" class="rounded-circle user-img-circle h-8 w-8 mt-4 mb-3" alt="img">
						<h4 class="mb-1  font-weight-semibold">Daneil Scott</h4>
						<h6>Calling...</h6>
						<div class="mt-5">
							<div class="row">
								<div class="col-4">
									<a class="icon icon-shape rounded-circle mb-0 mr-3" href="#">
										<i class="fas fa-volume-up bg-light"></i>
									</a>
								</div>
								<div class="col-4">
									<a class="icon icon-shape rounded-circle text-white mb-0 mr-3" href="#" data-dismiss="modal" aria-label="Close">
										<i class="fas fa-phone text-white bg-success"></i>
									</a>
								</div>
								<div class="col-4">
									<a class="icon icon-shape  rounded-circle mb-0 mr-3" href="#">
										<i class="fas fa-microphone-slash bg-light"></i>
									</a>
								</div>
							</div>
						</div>
					</div><!-- modal-body -->
				</div>
			</div><!-- modal-dialog -->
		</div>
<!-- modal -->









