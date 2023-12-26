@props(['tagsCsv'])

<ul class="flex">
    @foreach(explode(',',$tagsCsv) as $tag)
        <li
            class="bg-black text-white rounded-xl px-3 py-1 mr-2"
        >
            <a href="/?tag={{$tag}}">{{ucwords($tag)}}</a>
        </li>
    @endforeach
</ul>
