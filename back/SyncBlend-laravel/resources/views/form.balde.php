<form action="{{ route('submitForm', $form->id) }}" method="POST">
    @csrf
    @foreach($questions as $question)
        <div class="question">
            <label>{{ $question->question }}</label>
            <select name="answers[{{ $question->id }}]">
                @foreach($usersInGroup as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} {{ $user->lastname }}</option>
                @endforeach
            </select>
        </div>
    @endforeach
    <button type="submit">Enviar</button>
</form>
