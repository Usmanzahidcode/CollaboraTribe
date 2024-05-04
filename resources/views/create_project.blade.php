<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Submit new project | CollaboraTribe</title>
    @include('components.head')
</head>

<body>

@include('components.header')

<div class="container-fluid py-5 bg-light-subtle">
    <div class="container-sm">
        <div class="col-12 col-md-10 mx-auto">
            <h1 class="serif display-5">Post new Project</h1>
            @if(session('project_posted_success') != null)
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Project Posted!</strong> <i>Waiting approval from admin.</i>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @else
                {{-- Project Creation Limit --}}
                @if($projectsCount >= 2)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Limit reached!</strong> <i>You can't spam otherwise you will be banned.</i>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @elseif($projectsCount == 1)
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>You can post one more project!</strong> <i>Post only if necessary.</i>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

            @endif
            <p class=" my-3">This is the start of collaboration process.
                Fill the complete form and submit.
                <span
                    class="badge text-bg-danger p5">Guidelines:</span> Be responsible. Act like you would
                in
                real life. Be as detailed as possible.</p>
            <form action="{{ route('projects.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="input-group mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-default">Title</span>
                    <input value="{{ old('title') }}" name="title" type="text"
                           class="form-control @error('title') is-invalid @enderror"
                           placeholder="A self explaining title"
                           aria-label="Sizing example input"
                           aria-describedby="inputGroup-sizing-default">
                </div>

                <p class="form-text text-danger">@error('title') {{$message}} @enderror</p>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-default">Excerpt</span>
                    <input value="{{ old('excerpt') }}" name="excerpt" type="text"
                           class="form-control @error('excerpt') is-invalid @enderror"
                           aria-label="Sizing example input"
                           aria-describedby="inputGroup-sizing-default"
                           placeholder="A medium length excerpt that gives basic information about your project."
                    >
                </div>
                <p class="form-text text-danger">@error('excerpt') {{$message}} @enderror</p>
                <textarea name="description" type="text" class="form-control"
                          aria-label="Sizing example input"
                          aria-describedby="inputGroup-sizing-default" id="article_editor"
                          placeholder="Explain everything about the project. What you are going to make, what kind of talent you are looking for. What will be the role of those required team members. Share the github repo link if you have one. ">
						 {{ old('description') }}</textarea>

                <p class="form-text text-danger">@error('description') {{$message}} @enderror</p>
                <div class="input-group flex-nowrap  mt-3">
                    <input name="attachment"
                           type="file"
                           class="form-control @error('attachment') is-invalid @enderror" required/>
                </div>
                <p class="form-text">@error('attachment') {{$message}} @enderror</p>

                <select name="category" class="form-select mt-3" aria-label="Default select example"
                        required>
                    <option value="Web Development">Web Development</option>
                    <option value="Mobile App Development">Mobile App Development</option>
                    <option value="Desktop Application Development">Desktop Application Development</option>
                    <option value="DevOps and Automation">DevOps and Automation</option>
                    <option value="Data Science and Analytics">Data Science and Analytics</option>
                    <option value="Machine Learning">Machine Learning</option>
                    <option value="Artificial Intelligence">Artificial Intelligence</option>
                    <option value="Game Development">Game Development</option>
                    <option value="Algorithm Design and Optimization">Algorithm Design and Optimization
                    </option>
                    <option value="Cloud Computing and Virtualization">Cloud Computing and Virtualization
                    </option>
                    <option value="Internet of Things (IoT)">Internet of Things (IoT)</option>
                    <option value="Database Systems">Database Systems</option>
                    <option value="Cybersecurity and Ethical Hacking">Cybersecurity and Ethical Hacking
                    </option>
                    <option value="UI/UX Design and Prototyping">UI/UX Design and Prototyping</option>
                    <option value="Augmented Reality (AR) and Virtual Reality (VR)">Augmented Reality (AR) and
                        Virtual Reality (VR)
                    </option>
                    <option value="Embedded Systems and Robotics">Embedded Systems and Robotics</option>
                    <option value="Blockchain and Cryptocurrency">Blockchain and Cryptocurrency</option>
                    <option value="Natural Language Processing (NLP)">Natural Language Processing (NLP)
                    </option>
                    <option value="Graphics and Multimedia">Graphics and Multimedia</option>
                    <option value="Software Testing and Quality Assurance">Software Testing and Quality
                        Assurance
                    </option>
                    <option value="3">OTHER</option>
                </select>
                <div class="d-flex justify-content-center">
                    <input type="submit" value="Submit" class="btn btn-success mt-3 w-25 fw-medium">
                </div>


            </form>
        </div>

    </div>
</div>

@include('components.footer')

<!-- Full blown CKeditor, Not needed for this projects, can't support images. -->
<!--<script src = "https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/ckeditor.js"></script>-->

<script src="{{ asset('assets/js/ckeditor/build/ckeditor.js') }}"></script>
<script>
    ClassicEditor
        .create(document.querySelector("#article_editor"))
        .catch((error) => {
            console.error(error);
        });

</script>
<style>
    .ck-editor__editable_inline {
        min-height: 200px;
    }
</style>

</body>
</html>
