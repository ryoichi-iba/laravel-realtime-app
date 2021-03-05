@extends('layouts.app')

@push('scripts')
<style type="text/css">

</style>
@endpush
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">{{ __('Chat') }}</div>
                <div class="card-body">
                    <div class="row p-2">
                        <div class="col-10">
                            <div class="col-12 border rounded-lg p-3">
                                <ul id="messages" class="list-unstyled overflow-auto" style="height: 45vh">
                                    <li>Test1: Hello</li>
                                    <li>Test2: Hi there</li>
                                </ul>
                            </div>
                            <form action="">
                                <div class="row py-3">
                                    <div class="col-10">
                                        <input id="message" type="text" class="form-control" />
                                    </div>
                                    <div class="col-2">
                                        <button id="send" type="submit" class="btn btn-primary btn-block">Send</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-2">
                          <p><strong>Online Now</strong></p>
                          <ul id="users" class="users list-unstyled overflow-auto text-info" style="height: 45vh" >

                          </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<script>
  const usersElement = document.getElementById('users');

  Echo.join('chat')
      .here((users) => {
        users.forEach( (user,index) => {
            let element = document.createElement('li');

            element.setAttribute('id', user.id);
            element.innerText = user.name;

            usersElement.appendChild(element);
        });
      })
      .joining((user) => {
            let element = document.createElement('li');

            element.setAttribute('id', user.id);
            element.innerText = user.name;

            usersElement.appendChild(element);
      })
      .leaving((user) => {
        const element = document.getElementById(user.id);
        element.parentNode.removeChild(element);
      })
</script>

<script>
  const messageElement = document.getElementById('message');
  const sendElement = document.getElementById('send');

  sendElement.addEventListener('click', (e) => {
    e.preventDefault();
    
    window.axios.post('/chat/message', {
      message: messageElement.value,
    });
    messageElement.value = '';
  });
</script>
@endpush
