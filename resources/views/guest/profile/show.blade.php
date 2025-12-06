@extends('layouts.guest')

@section('title', 'Profil Saya - Sistem Informasi Persil')

@section('content')
<section class="wrapper style2">
    <div class="inner">
        <header class="align-center">
            <p>Manajemen Profil</p>
            <h2>Profil Pengguna</h2>
        </header>

        <!-- Alert Messages -->
        @if(session('success'))
        <div style="background: #4CAF50; color: white; padding: 1em; border-radius: 5px; margin-bottom: 1em;">
            <strong>Berhasil!</strong> {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div style="background: #f44336; color: white; padding: 1em; border-radius: 5px; margin-bottom: 1em;">
            <strong>Error!</strong> {{ session('error') }}
        </div>
        @endif

        <!-- Profile Card -->
        <div class="profile-container">
            <div class="profile-card">
                <!-- Profile Header -->
                <div class="profile-header">
                    <div class="profile-photo">
                        @if($user->photo_path)
                            <img src="{{ asset('storage/' . $user->photo_path) }}" alt="{{ $user->name }}">
                        @else
                            <div class="profile-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                        @endif
                    </div>
                    <div class="profile-info">
                        <h3>{{ $user->name }}</h3>
                        <p class="role-badge">{{ ucfirst($user->role) }}</p>
                    </div>
                    <div class="profile-actions">
                        <a href="{{ route('profile.edit') }}" class="button special">Edit Profil</a>
                    </div>
                </div>

                <!-- Profile Details -->
                <div class="profile-details">
                    <div class="detail-item">
                        <span class="detail-icon">📧</span>
                        <div class="detail-content">
                            <small>Email</small>
                            <strong>{{ $user->email }}</strong>
                        </div>
                    </div>

                    <div class="detail-item">
                        <span class="detail-icon">📅</span>
                        <div class="detail-content">
                            <small>Bergabung Sejak</small>
                            <strong>{{ $user->created_at->format('d M Y') }}</strong>
                        </div>
                    </div>

                    <div class="detail-item">
                        <span class="detail-icon">🔄</span>
                        <div class="detail-content">
                            <small>Terakhir Diupdate</small>
                            <strong>{{ $user->updated_at->format('d M Y H:i') }}</strong>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="profile-stats">
                    <div class="stat-item">
                        <div class="stat-number">{{ $user->persils()->count() }}</div>
                        <div class="stat-label">Data Persil</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">{{ $user->persils()->with('dokumen')->get()->sum(function($persil) { return $persil->dokumen->count(); }) }}</div>
                        <div class="stat-label">Dokumen</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Links -->
        <div style="text-align: center; margin-top: 2em;">
            <a href="{{ route('guest.persil.index') }}" class="button">Kembali ke Dashboard</a>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .profile-container {
        max-width: 800px;
        margin: 2em auto;
    }

    .profile-card {
        background: #ffffff;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        border: 2px solid #f0f0f0;
    }

    /* Profile Header */
    .profile-header {
        background: linear-gradient(135deg, #2ebaae 0%, #1fa99c 100%);
        padding: 2em;
        display: flex;
        align-items: center;
        gap: 1.5em;
        color: white;
        flex-wrap: wrap;
    }

    .profile-photo {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        overflow: hidden;
        border: 4px solid rgba(255, 255, 255, 0.3);
        background: rgba(255, 255, 255, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .profile-photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-avatar {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3em;
        font-weight: 700;
        color: white;
        background: rgba(255, 255, 255, 0.2);
    }

    .profile-info {
        flex: 1;
        min-width: 200px;
    }

    .profile-info h3 {
        margin: 0 0 0.5em 0;
        font-size: 1.8em;
        font-weight: 700;
        color: #ffffff;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
    }

    .role-badge {
        display: inline-block;
        background: rgba(255, 255, 255, 0.2);
        color: white;
        padding: 0.3em 0.8em;
        border-radius: 20px;
        font-size: 0.85em;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .profile-actions {
        flex-shrink: 0;
    }

    .profile-actions .button {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.3);
        padding: 0.8em 1.5em;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .profile-actions .button:hover {
        background: white;
        color: #2ebaae;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    /* Profile Details */
    .profile-details {
        padding: 2em;
        background: #f8f9fa;
    }

    .detail-item {
        display: flex;
        align-items: flex-start;
        gap: 1em;
        padding: 1em 0;
        border-bottom: 1px solid #e9ecef;
    }

    .detail-item:last-child {
        border-bottom: none;
    }

    .detail-icon {
        font-size: 1.5em;
        min-width: 40px;
        text-align: center;
        flex-shrink: 0;
    }

    .detail-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 0.3em;
    }

    .detail-content small {
        font-size: 0.75em;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 700;
    }

    .detail-content strong {
        font-size: 1em;
        color: #212529;
        font-weight: 600;
        word-break: break-word;
    }

    /* Profile Stats */
    .profile-stats {
        padding: 2em;
        background: white;
        display: flex;
        justify-content: center;
        gap: 2em;
        border-top: 2px solid #f0f0f0;
        flex-wrap: wrap;
    }

    .stat-item {
        text-align: center;
        min-width: 100px;
    }

    .stat-number {
        font-size: 2em;
        font-weight: 700;
        color: #2ebaae;
        margin-bottom: 0.3em;
    }

    .stat-label {
        font-size: 0.85em;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .profile-header {
            flex-direction: column;
            text-align: center;
            gap: 1em;
        }

        .profile-photo {
            width: 100px;
            height: 100px;
        }

        .profile-avatar {
            font-size: 2.5em;
        }

        .profile-info h3 {
            font-size: 1.5em;
        }

        .profile-stats {
            gap: 1em;
        }

        .stat-item {
            min-width: 80px;
        }
    }

    @media (max-width: 480px) {
        .profile-stats {
            flex-direction: column;
            gap: 1.5em;
        }

        .stat-item {
            min-width: auto;
        }
    }
</style>
@endpush
