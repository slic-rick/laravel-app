<x-layout>
    <div class="container py-md-5 container--narrow">
      
        <form action="/create-post" method="POST">
            @csrf
          <div class="form-group">
            <label for="post-title" class="text-muted mb-1"><small>Title</small></label>
            <input value="{{@old('title')}}"  name="title" id="post-title" class="form-control form-control-lg form-control-title" type="text" placeholder="" autocomplete="off" />
          @error('title')
              <p class="m-0 alert alert-danger">{{$message}}</p>
          @enderror
          </div>

          <div class="form-check">
            <input class="form-check-input" type="radio" name="category" id="web" value="Web" >
            <label class="form-check-label" for="web">
              Web
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="category" id="mobile" value="Mobile">
            <label class="form-check-label" for="mobile">
              Mobile
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="category" id="finance" checked value="Finance">
            <label class="form-check-label" for="finance">
              Finance
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="category" id="ai" value="AI">
            <label class="form-check-label" for="ai">
              AI
            </label>
          </div>
  
          <div class="form-group">
            <label for="post-body" class="text-muted mb-1"><small>Body Content</small></label>
            <textarea  name="body" id="post-body" class="body-content tall-textarea form-control" type="text">{{@old('body')}}</textarea>
          @error('body')
              <p class="m-0 alert alert-danger">{{$message}}</p>
          @enderror
          </div>
  
          <button class="btn btn-primary">Save New Post</button>
        </form>
      </div>
</x-layout>