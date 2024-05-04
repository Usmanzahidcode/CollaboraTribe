<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Edit project | CollaboraTribe</title>
    @include('components.head')
</head>
<body>

@include('components.header')

<div class="container-fluid py-5 bg-light-subtle">
    <div class="container-sm">
        <div class="col-12 col-md-10 mx-auto">
            <h1 class="serif display-5">Edit you Project</h1>
            @if(session('project_updated_success') != null)
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Project Updated!</strong> <i>Keep up the good work.</i>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <p class=" my-3">Update your project, and remove any errors that you might have made by errors.
                <span
                    class="badge text-bg-danger p5">Guidelines:</span> Be responsible. Act like you would
                in
                real life. Be as detailed as possible.</p>
            <form action="{{ route('projects.update', ['project' => $project->id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="input-group mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-default">Title</span>
                    <input value="{{ $project->title }}" name="title" type="text"
                           class="form-control @error('title') is-invalid @enderror"
                           placeholder="A self explaining title"
                           aria-label="Sizing example input"
                           aria-describedby="inputGroup-sizing-default">
                </div>

                <p class="form-text text-danger">@error('title') {{$message}} @enderror</p>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-default">Excerpt</span>
                    <input value="{{ $project->excerpt }}" name="excerpt" type="text"
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
						  {!! $project->description !!}</textarea>

                <p class="form-text text-danger">@error('description') {{$message}} @enderror</p>
                <p class="form-text text-primary  mt-3">Change files only if necessary!</p>
                <div class="input-group flex-nowrap">
                    <input name="attachment"
                           type="file"
                           class="form-control @error('attachment') is-invalid @enderror"/>
                </div>
                <p class="form-text">@error('attachment') {{$message}} @enderror</p>

                <select name="category" class="form-select mt-3" aria-label="Default select example"
                        required>
                    <option value="Web Development" {{  $project->category == 'Web Development' ?  'selected' : '' }}>
                        Web Development
                    </option>
                    <option
                        value="Mobile App Development" {{  $project->category == 'Mobile App Development' ?  'selected' : '' }}>
                        Mobile App Development
                    </option>
                    <option
                        value="Desktop Application Development" {{  $project->category == 'Desktop Application Development' ?  'selected' : '' }}>
                        Desktop Application Development
                    </option>
                    <option
                        value="DevOps and Automation" {{  $project->category == 'DevOps and Automation' ?  'selected' : '' }}>
                        DevOps and Automation
                    </option>
                    <option
                        value="Data Science and Analytics" {{  $project->category == 'Data Science and Analytics' ?  'selected' : '' }}>
                        Data Science and Analytics
                    </option>
                    <option value="Machine Learning" {{  $project->category == 'Machine Learning' ?  'selected' : '' }}>
                        Machine Learning
                    </option>
                    <option
                        value="Artificial Intelligence" {{  $project->category == 'Artificial Intelligence' ?  'selected' : '' }}>
                        Artificial Intelligence
                    </option>
                    <option value="Game Development" {{  $project->category == 'Game Development' ?  'selected' : '' }}>
                        Game Development
                    </option>
                    <option
                        value="Algorithm Design and Optimization" {{  $project->category == 'Algorithm Design and Optimization' ?  'selected' : '' }}>
                        Algorithm Design and Optimization
                    </option>
                    <option
                        value="Cloud Computing and Virtualization" {{  $project->category == 'Cloud Computing and Virtualization' ?  'selected' : '' }}>
                        Cloud Computing and Virtualization
                    </option>
                    <option
                        value="Internet of Things (IoT)" {{  $project->category == 'Internet of Things (IoT)' ?  'selected' : '' }}>
                        Internet of Things (IoT)
                    </option>
                    <option value="Database Systems" {{  $project->category == 'Database Systems' ?  'selected' : '' }}>
                        Database Systems
                    </option>
                    <option
                        value="Cybersecurity and Ethical Hacking" {{  $project->category == 'Cybersecurity and Ethical Hacking' ?  'selected' : '' }}>
                        Cybersecurity and Ethical Hacking
                    </option>
                    <option
                        value="UI/UX Design and Prototyping" {{  $project->category == 'UI/UX Design and Prototyping' ?  'selected' : '' }}>
                        UI/UX Design and Prototyping
                    </option>
                    <option
                        value="Augmented Reality (AR) and Virtual Reality (VR)" {{  $project->category == 'Augmented Reality (AR) and Virtual Reality (VR)' ?  'selected' : '' }}>
                        Augmented Reality (AR) and
                        Virtual Reality (VR)
                    </option>
                    <option
                        value="Embedded Systems and Robotics" {{  $project->category == 'Embedded Systems and Robotics' ?  'selected' : '' }}>
                        Embedded Systems and Robotics
                    </option>
                    <option
                        value="Blockchain and Cryptocurrency" {{  $project->category == 'Blockchain and Cryptocurrency' ?  'selected' : '' }}>
                        Blockchain and Cryptocurrency
                    </option>
                    <option
                        value="Natural Language Processing (NLP)" {{  $project->category == 'Natural Language Processing (NLP)' ?  'selected' : '' }}>
                        Natural Language Processing (NLP)
                    </option>
                    <option
                        value="Graphics and Multimedia" {{  $project->category == 'Graphics and Multimedia' ?  'selected' : '' }}>
                        Graphics and Multimedia
                    </option>
                    <option
                        value="Software Testing and Quality Assurance" {{  $project->category == 'Software Testing and Quality Assurance' ?  'selected' : '' }}>
                        Software Testing and Quality
                        Assurance
                    </option>
                    <option value="other" {{  $project->category == 'other' ?  'selected' : '' }}>OTHER</option>
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
