@extends('frontend.dashboard.dashboard')
@section('dashboard')
<title>Chat with Pharmacy</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
    $(document).ready(function () {

        $('.fp__chat_area').on('click', function () {
            let senderId = 1;

            $.ajax({
                method: 'GET',
                url: '{{ route("chat.uget-conversation", ":senderId") }}'.replace(":senderId", senderId),
                beforeSend: function () {
                    // Optional: Add loading animation or logic here
                },
                success: function (response) {
                    console.log(response);
                    $('.fp__chat_body').empty(); // Clear chat content

                    // Populate chat messages
                    $.each(response.messages, function (index, message) {
                        // Use the dynamic admin ID to check the sender
                        let photo;
                        let messageClass = ''; // Variable to hold the class for different styling
                        let messageBackground = ''; // Background color for user/admin
                        let messagePosition = ''; // Class for message position (left or right)

                        if (message.sender_id == response.adminId) {  // Dynamically compare sender's ID with admin's ID
                            photo = response.adminPhoto; // Admin's photo path
                            messageClass = 'admin-message'; // Add class for admin
                            messageBackground = '#ffffff'; // White for admin
                            messagePosition = 'admin-position'; // Position for admin on the right
                        } else {
                            // For users, fetch their photo
                            photo = "{{ asset('upload/user_images/') }}/" + message.sender.photo;
                            messageClass = 'user-message'; // Add class for user
                            messageBackground = '#a1c4fd'; // Blue for user
                            messagePosition = 'user-position'; // Position for user on the left
                        }

                        let html = `
                    <div class="fp__chating ${messageClass} ${messagePosition}" style="display: flex; margin-bottom: 15px; align-items: flex-start; justify-content: ${messagePosition === 'admin-position' ? 'flex-end' : 'flex-start'};">
                        <div class="fp__chating_img" style="margin-${messagePosition === 'admin-position' ? 'left' : 'right'}: 10px;">
                            <img src="${photo}" style="width: 40px; height: 40px; border-radius: 50%; border: 1px solid #ddd;">
                        </div>
                        <div class="fp__chating_text"
                             style="background-color: ${messageBackground}; padding: 15px; border-radius: 10px; max-width: 80%; box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1); text-align: ${messagePosition === 'admin-position' ? 'right' : 'left'};">
                            <p style="margin: 0; font-size: 14px; line-height: 1.6; color: #333;">${message.message}</p>
                            <span style="font-size: 12px; color: #888; display: block; margin-top: 5px;">sending...</span>
                        </div>
                    </div>
                `;

                        $('.fp__chat_body').append(html);
                    });
                },
                error: function (xhr, status, error) {
                    // Handle errors
                    console.error("Error fetching conversation:", error);
                }
            });
        });
        $('.chat_input').on('submit', function (e) {
            e.preventDefault();
            let formData = $(this).serialize(); // Serialize form data
            $.ajax({
                method: 'POST',
                url: "{{ route('chat.send-message') }}", // Ensure this route is correct
                data: formData, // Sending serialized form data
                beforeSend: function () {
                    let message = $('.fp_send_message').val();
                    // <!-- Single Chat Message (Right) -->
                    let html = ` 
    <div class="fp__chating tf_chat_right"
         style="display: flex; justify-content: flex-end; margin-bottom: 15px; align-items: flex-end;">
        <div class="fp__chating_text"
             style="background-color: #007bff; color: rgb(0, 0, 0); padding: 15px; border-radius: 10px; max-width: 80%; text-align: left; box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);">
            <p style="margin: 0; font-size: 14px; line-height: 1.6;">${message}</p>
            <span style="font-size: 12px; color: #d1e7ff; display: block; margin-top: 5px;">Sending..</span>
        </div>
        <div class="fp__chating_img" style="margin-left: 10px;">
            <img src="{{ (!empty(auth()->user()->photo)) ? url('upload/user_images/' . auth()->user()->photo) : url('upload/no_image.jpg') }}" 
                 class="img-fluid" 
                 style="width: 40px; height: 40px; border-radius: 50%; border: 1px solid #ddd;">
        </div>
                        </div>`;


                    $('.fp__chat_body').append(html)
                    $('.fp_send_message').val("");
                },
                success: function (response) {
                    console.log("Message sent successfully:", response); // Log the response
                },
                error: function (xhr, status, error) {
                    let errors = xhr.responseJSON.errors;
                    $.each(error, function (key, value) {
                        toastr.error(value);
                    })
                }
            });
        });
    });
</script>




<div class="fp_dashboard_body fp__change_password">
    <div class="fp__message">
        <h3 class="text-center">Message</h3>
        <div class="container"
            style="max-width: 1000px; margin: 0 auto; padding: 20px; background-color: #f9f9f9; border-radius: 10px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
            <div class="fp__chat_area">
                <!-- Chat Body Section -->
                <div class="fp__chat_body" style="padding: 20px;">
                    <!-- Single Chat Message (Left) -->
                    <!-- <div class="fp__chating" style="display: flex; margin-bottom: 15px; align-items: flex-start;">
                        <div class="fp__chating_img" style="margin-right: 10px;">
                            <img src="images/service_provider.png" alt="Service Provider" class="img-fluid"
                                style="width: 40px; height: 40px; border-radius: 50%; border: 1px solid #ddd;">
                        </div>
                        <div class="fp__chating_text"
                            style="background-color: #ffffff; padding: 15px; border-radius: 10px; max-width: 80%; box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);">
                            <p style="margin: 0; font-size: 14px; line-height: 1.6; color: #333;">Lorem ipsum dolor sit
                                amet consectetur adipisicing elit. Pariatur qui amet aperiam.</p>
                            <span style="font-size: 12px; color: #888; display: block; margin-top: 5px;">15 Jun, 2023,
                                05:26 AM</span>
                        </div>
                    </div> -->

                    <!-- Single Chat Message (Right) -->
                    <!-- <div class="fp__chating tf_chat_right"
                        style="display: flex; justify-content: flex-end; margin-bottom: 15px; align-items: flex-end;">
                        <div class="fp__chating_text"
                            style="background-color: #007bff; color:rgb(0, 0, 0); padding: 15px; border-radius: 10px; max-width: 80%; text-align: left; box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);">
                            <p style="margin: 0; font-size: 14px; line-height: 1.6;">Lorem ipsum dolor sit amet
                                consectetur adipisicing elit.</p>
                            <span style="font-size: 12px; color: #d1e7ff; display: block; margin-top: 5px;">15 Jun,
                                2023, 05:26 AM</span>
                        </div>
                        <div class="fp__chating_img" style="margin-left: 10px;">
                            <img src="images/client_img_1.jpg" alt="Client" class="img-fluid"
                                style="width: 40px; height: 40px; border-radius: 50%; border: 1px solid #ddd;">
                        </div>
                    </div> -->
                </div>

                <!-- Chat Input Section -->
                <form class="fp__single_chat_bottom chat_input"
                    style="display: flex; align-items: center; gap: 10px; margin-top: 20px; padding: 10px; background-color: #fff; border-radius: 20px; box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);">
                    @csrf
                    <input id="select_file" type="file" hidden>

                    <input type="text" placeholder="Type a message..." name="message" class="fp_send_message"
                        style="flex-grow: 1; height: 40px; padding: 0 15px; border: none; border-radius: 20px; background-color: #f1f1f1; font-size: 16px;">

                    <input type="hidden" name="receiver_id" value="1"
                        style="flex-grow: 1; height: 40px; padding: 0 15px; border: none; border-radius: 20px; background-color: #f1f1f1; font-size: 16px;">


                    <button type="submit" class="fp__massage_btn"
                        style="display: flex; align-items: center; justify-content: center; background-color: #007bff; color: #ffffff; width: 40px; height: 40px; border: none; border-radius: 50%; cursor: pointer; box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.1);">
                        <i class="fas fa-paper-plane" style="margin-top: -2px;"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection





<style>
    /* Chat Bubble Styling */
    .chat-bubble-right {
        background-color: #007bff;
        /* Blue background */
        color: #000;
        /* Black text color */
        padding: 10px 15px;
        border-radius: 8px;
        max-width: 70%;
        /* Consistent width */
        text-align: left;
        /* Keep text aligned properly */
        word-wrap: break-word;
        box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        /* Subtle shadow for better visibility */
        margin-left: auto;
        /* Push bubble to the right */
    }

    /* Chat Right Alignment */
    .fp__chating.tf_chat_right {
        display: flex;
        justify-content: flex-end;
        /* Align content to the right */
        margin-bottom: 15px;
        align-items: flex-end;
    }

    /* Adjust Image Margin for Right Chat */
    .fp__chating.tf_chat_right .fp__chating_img {
        margin-left: 10px;
    }

    /* Chat Time Styling */
    .chat-time {
        font-size: 12px;
        color: #555;
        /* Neutral text color for the time */
        display: block;
        margin-top: 5px;
    }
</style>