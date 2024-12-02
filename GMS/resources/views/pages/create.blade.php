<h1>Create a New Page</h1>
<form action="{{ route('pages.store') }}" method="POST">
    @csrf
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" required>
    <br>
    <label for="content">Content:</label>
    <textarea id="content" name="content" required></textarea>
    <br>
    <button type="submit">Create Page</button>
</form>