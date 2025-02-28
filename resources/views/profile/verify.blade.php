<x-app-layout>
    @error('uuid')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    @error('code')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <form action="{{route('profile.verify')}}" method="POST">
        @csrf
        <input type="hidden" name="uuid" value="{{$uuid}}">
        <input type="number" name="code">
        <button type="submit">Verify</button>
    </form>
</x-app-layout>
