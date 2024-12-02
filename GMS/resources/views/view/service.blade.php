<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Our Services</h1>
            <div class="card-deck">
                @foreach($services as $service)
                    <div class="card">
                        <!-- Add an icon or image here -->
                        <div class="card-body">
                            <i class="service-icon">{{ $service->icon ?? '🔧' }}</i>
                            <h5 class="card-title">{{ $service->service_name }}</h5>
                            <p>{{ $service->price }}</p>
                            <a href="{{ route('service.show', $service->id) }}" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>