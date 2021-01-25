@extends('dashboard.index')
@section('title', '- Poruke')
@section('dashboard.content')
<h1 class="dashboard__content-title">Poruke</h1>
@if($contacts->count())
    @foreach($contacts as $contact)

        <div class="openable u-margin-bottom-sm @if($contact->read) openable--success @else openable--false @endif" >
            <div class="openable__closed" id="openable_closed">
                <h3 class="openable__title">Poruka od {{ $contact->name }}</h3>
                <div class="openable__icon" id="openable__toggle"><i class="fas fa-info"></i></div>
            </div>

            <div class="openable__content" data-id='{{ $contact->id }}'>
                <div class="row">
                    <div class="col-md-4">
                        <div class="openable__content-info"> 
                            <h3 class="openable__content-info-text">Ime: {{ $contact->name }}</h3>
                            <h3 class="openable__content-info-text">Email: {{ $contact->email }}</h3>
                            <h3 class="openable__content-info-text">IP Adresa: {{ $contact->ip_address }}</h3>
                            <h3 class="openable__content-info-text">Browser: {{ $contact->browser }}</h3>
                            <h3 class="openable__content-info-text">OS: {{ $contact->os }}</h3>
                        </div>                    
                    </div>
                    <div class="col-md-12">
                        <div class="openable__content-textarea-wrapper">
                            <h3 class="openable__content-textarea">{{ $contact->message }}
                                <br>
                            </h3>
                            <div class="openable__content-actions">
                                <a href="mailto:{{ $contact->email }}" class="openable__content-action openable__content-action--reply"><i class="fas fa-reply"></i></a>
                                <form action="/dashboard/contact/{{ $contact->id }}" method='POST'>
                                    @csrf
                                    @method('DELETE')    
                                    <button type="submit" class="openable__content-action openable__content-action--delete"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
@else
<h1>Trenutno nema poruka</h1>
@endif
{{ $contacts->links() }}



<script>
    
        const openableClosed = document.querySelectorAll('#openable_closed');
        openableClosed.forEach(element => {
            element.addEventListener('click', (event) => {
                toggleOpenable(event.target);
            });
        });

        function toggleOpenable(element){
            let openable = element.parentElement.children[1];
            /*
            #FIXME
            @desc:
                For some reason it selects an icon element
            */
            if(openable.classList.contains('openable__icon')) return;
            let id = openable.getAttribute('data-id');
            
            if(id){
                window.axios.post(`/dashboard/contact/${id}` , {
                _method: 'patch'
                })
                .then(response => {
                    
                })
                .catch( e => {
                  
                });
            }
            if(openable){
                openable.classList.toggle('openable__content--opened');
            }
            
        }
    
    

</script>

@endsection