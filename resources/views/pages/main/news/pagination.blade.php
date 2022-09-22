  @forelse ($news as $ix => $new)
  <a href="{{route('news-view.detail', $new->slug)}}" class="single-article col-lg-4">
    <div class="card">
      <img class="card-img-top" src="{{ asset('@getPath(news)'.$new->photo) }}" alt="{{$new->title}}">
      <div class="card-body">
        <h5>{{$new->title}}</h5>
        <span>{{ \Carbon\Carbon::parse($new->date)->isoFormat('dddd, D MMMM Y') }}</span>
        <p>{!! \Illuminate\Support\Str::limit($new->description, 120, $end='...') !!}</p>
      </div>
    </div>
  </a>
  @empty
  Belum ada artikel
  @endforelse