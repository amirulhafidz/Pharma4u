@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        var userId = @json($adminId);
        console.log(userId);

        // Clear receiver ID on page load
        $('#receiver_id').val("");

        // Handle chat user selection
        $('.fp_chat_user').on('click', function () {
            let senderId = $(this).data('user');
            $('#receiver_id').val(senderId);

            $.ajax({
                method: 'GET',
                url: '{{ route("chat.get-conversation", ":senderId") }}'.replace(":senderId", senderId),
                beforeSend: function () {
                    // Optional: Add loading animation or logic here
                },
                success: function (response) {
                    console.log(response);
                    $('.chat-content').empty(); // Clear chat content

                    // Populate chat messages
                    $.each(response.messages, function (index, message) {
                        // Use the dynamic admin ID to check the sender
                        let photo;
                        if (message.sender_id == response.adminId) {  // Dynamically compare sender's ID with admin's ID
                        photo = response.adminPhoto; // Admin's photo path
                    } else {
                        // For users, fetch their photo
                        photo = "{{ asset('upload/user_images/') }}/" + message.sender.photo;
                    }

                            let html = `
                            <div class="fp__chating" 
                                style="display: flex; margin-bottom: 15px; align-items: flex-start; justify-content: ${message.sender_id == userId ? 'flex-end' : 'flex-start'};">
                                
                                <!-- Image Container -->
                                <div class="fp__chating_img" style="order: ${message.sender_id == userId ? 2 : 1}; margin-${message.sender_id == userId ? 'right' : 'left'}: 10px;">
                                    <img src="${photo}" 
                                        class="img-fluid" 
                                        style="width: 40px; height: 40px; border-radius: 50%; border: 1px solid #ddd;">
                                </div>
                                
                                <!-- Message Bubble -->
                                <div class="fp__chating_text"
                                    style="background-color: ${message.sender_id == userId ? '#007bff' : '#ffffff'}; padding: 15px; border-radius: 10px; max-width: 80%; box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1); order: ${message.sender_id == userId ? 1 : 2};">
                                    <p style="margin: 0; font-size: 14px; line-height: 1.6; color: ${message.sender_id == userId ? '#fff' : '#333'};">
                                        ${message.message}
                                    </p>
                                    <span style="font-size: 12px; color: #888; display: block; margin-top: 5px;">
                                        15 Jun, 2023, 05:26 AM
                                    </span>
                                </div>
                            </div>
                        `;

                $('.chat-content').append(html);
            });

                },
                error: function (xhr, status, error) {
                    // Handle errors
                    console.error("Error fetching conversation:", error);
                }
            });
        });

        // Handle message sending
        $('#chat-form').on('submit', function (e) {
            e.preventDefault();
            let message = $('.fp_send_message').val();
            let formData = $(this).serialize(); // Serialize form data

            $.ajax({
                method: 'POST',
                url: "{{ route('chat.adsend-message') }}", // Ensure this route is correct
        data: formData,
                success: function (response) {
                    console.log("Message sent successfully:", response); // Log response
                    let photo;

            // Dynamically compare sender's ID with admin's ID
            
                photo = response.adminPhoto; // Admin's photo path
         

                    // Create HTML structure for the message
                    let html = `
                <div class="fp__chating chat-right"
                     style="display: flex; justify-content: flex-end; margin-bottom: 15px; align-items: flex-end;">
                    <div class="fp__chating_text"
                         style="background-color: #007bff; color: rgb(255, 255, 255); padding: 15px; 
                                border-radius: 10px; max-width: 80%; text-align: left; 
                                box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);">
                        <p style="margin: 0; font-size: 14px; line-height: 1.6;">
                            ${message}
                        </p>
                        <span style="font-size: 12px; color: #d1e7ff; display: block; margin-top: 5px;">
                            15 Jun, 2023, 05:26 AM
                        </span>
                    </div>
                    <div class="fp__chating_img" style="margin-left: 10px;">
                        <img src="${photo}" 
                 class="img-fluid" 
                 style="width: 40px; height: 40px; border-radius: 50%; border: 1px solid #ddd;">
                    </div>
                </div>
            `;
                    $('.chat-content').append(html); // Append the message
                    $('.fp_send_message').val(""); // Clear input field
                },
                error: function (xhr, status, error) {
                    // Handle errors
                    console.error("Error sending message:", error);
                }
            });
        });

    });
</script>




<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">All Messages</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">

                        <!-- Main Content -->

                        <section class="section">


                            <div class="section-body">

                                <div class="row align-items-center justify-content-center">
                                    <div class="col-12 col-sm-6 col-lg-3">
                                        <div class="card" style="height :70vh">
                                            <div class="card-header">
                                                <h4>Who's Online?</h4>
                                            </div>
                                            <div class="card-body">
                                                <ul class="list-unstyled list-unstyled-border">
                                                    @foreach ($chatUsers as $chatUser)
                                                    
                                                                                                    <li class="media fp_chat_user" data-user="{{$chatUser->id}}"
                                                                                                        style="cursor:pointer">
                                                                                                        <img src="{{ (!empty($chatUser->photo)) ?
        url('upload/user_images/' . $chatUser->photo) : url('upload/no_image.jpg') }}"
                                                                                                            class="img-fluid"
                                                                                                            style="width: 40px; height: 40px; border-radius: 50%; border: 1px solid #ddd;">
                                                                                                        <div class="media-body">
                                                                                                            <div class="mt-0 mb-1 font-weight-bold">{{$chatUser->name}}
                                                                                                            </div>
                                                                                                            <div class="text-success text-small font-600-bold">
                                                                                                                <i class="fas fa-circle"></i> Online
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </li>
                                                    @endforeach

                                                </ul>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-12 col-sm-6 col-lg-9">
                                        <div class="card chat-box" id="mychatbox"
                                            style="height: 70vh; display: flex; flex-direction: column;">
                                            <div class="card-header"
                                                style="padding: 10px 20px; background-color: #f8f9fa; border-bottom: 1px solid #ddd;">
                                                <h4 style="margin: 0; font-size: 18px;">Chat with Rizal</h4>
                                            </div>

                                            <!-- Chat Body -->
                                            <div class="fp__chat_body chat-content"
                                                style="flex-grow: 1; padding: 20px; background-color: #f8f9fa; overflow-y: auto; border-radius: 0 0 10px 10px;">



                                            </div>

                                            <!-- Chat Footer -->
                                            <div class="card-footer chat-form"
                                                style="padding: 10px 15px; background-color: #f8f9fa; border-top: 1px solid #ddd;">
                                                <form id="chat-form"
                                                    style="display: flex; align-items: center; gap: 10px; margin: 0;">
                                                    @csrf
                                                    <!-- Text Input Field -->
                                                    <input type="text" class="form-control fp_send_message"
                                                        placeholder="Type a message" name="message"
                                                        style="flex-grow: 1; padding: 10px; border-radius: 20px; border: 1px solid #ced4da; margin: 0;">

                                                    <input type="hidden" name="receiver_id" id="receiver_id" value=""
                                                        style="flex-grow: 1; padding: 10px; border-radius: 20px; border: 1px solid #ced4da; margin: 0;">


                                                    <!-- Send Button -->
                                                    <button class="btn btn-primary"
                                                        style="display: flex; align-items: center; justify-content: center; padding: 10px; border-radius: 50%; height: 40px; width: 40px; border: none; margin: 0;">
                                                        <i class="far fa-paper-plane" style="font-size: 16px;"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </section>


                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container-fluid -->
</div>

@endsection

<!-- <style>
    .chat-content {
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
}
</style> -->