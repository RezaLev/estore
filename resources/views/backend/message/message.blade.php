<div id="messages">
    <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-envelope fa-fw"></i>
        <!-- Counter - Messages -->
        @if(count(Helper::messageList())>5)
            <span id="messageCounter" data-count="5" class="badge badge-danger badge-counter">5+</span>
        @else 
            <span id="messageCounter" data-count="{{count(Helper::messageList())}}" class="badge badge-danger badge-counter">{{count(Helper::messageList())}}</span>
        @endif
    </a>
    <!-- Dropdown - Messages -->
    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
        <h6 class="dropdown-header">
        Message Center
        </h6>
        <div id="message-items">
            @foreach(Helper::messageList() as $message)
                <a class="dropdown-item d-flex align-items-center" href="{{route('message.show',$message->id)}}">
                    <div class="dropdown-list-image mr-3">
                        @if($message->photo)
                            <img class="rounded-circle" src="{{$message->photo}}" alt="profile">
                        @else 
                            <img class="rounded-circle" src="{{asset('backend/img/avatar.png')}}" alt="default img">
                        @endif
                    </div>
                    <div class="font-weight-bold">
                        <div class="text-truncate">{{$message->subject}}</div>
                        <div class="small text-gray-500">{{$message->name}} · {{$message->created_at->diffForHumans()}}</div>
                    </div>
                </a>
                @if($loop->index+1==5) 
                  @php 
                    break;
                  @endphp
                @endif
            @endforeach
        </div>
        <a class="dropdown-item text-center small text-gray-500" href="{{route('message.index')}}">Read More Messages</a>
    </div>
</div>



@push('scripts')
@push('scripts')
<script type="text/javascript">
  $(document).ready(function() {
    const messageCounterArea = $('#messageCounter');

    Echo.channel('message')
      .listen('MessageSent', (e) => {
        const messageContainer = $('#message-items');
        const messageCounter = parseInt(messageCounterArea.attr('data-count')) + 1;
        const messageLength = $('#message-items>.dropdown-item').length;

        messageCounterArea.attr('data-count', messageCounter);

        const data = `
        <a class="dropdown-item d-flex align-items-center message-item" href="${e.message.url}">
          <div class="dropdown-list-image mr-3">
            <img class="rounded-circle" src="${e.message.photo}" alt="${e.message.name}">
          </div>
          <div class="font-weight-bold">
            <div class="text-truncate">${e.message.subject}</div>
            <div class="small text-gray-500">${e.message.name} · ${e.message.date}</div>
          </div>
        </a>
        `;

        messageContainer.prepend(data);

        if (messageCounter <= 5) {
          messageCounterArea.text(messageCounter);
        } else {
          messageCounterArea.text('5+');
        }

        if (messageLength >= 5) {
          messageContainer.find('.message-item').last().remove();
        }
      });

    $('#messagesDropdown').on('show.bs.dropdown', function () {
      // Reset message counter
      messageCounterArea.attr('data-count', '0').text('0');

      // Optional: Send AJAX request to mark messages as read
      $.ajax({
        url: "{{ route('message.markAsRead') }}", // Replace with your route to mark messages as read
        method: "POST",
        data: {
          _token: "{{ csrf_token() }}"
        },
        success: function(response) {
          console.log('Messages marked as read');
        },
        error: function(xhr) {
          console.log('Error marking messages as read');
        }
      });
    });
  });
</script>
@endpush

@endpush
