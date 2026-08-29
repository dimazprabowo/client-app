{{--
    Auth Platform Illustration - Generic enterprise application visual.

    Template (boilerplate) context: enterprise application platform with
    authentication, role-based access control, and user management.
    Visual language: clean blueprint style with security shield center,
    user management card, and permission/role nodes connected by lines.

    Uses currentColor so it inherits the white text color of the blue
    gradient branding panel. Inline SVG (no external asset dependency).
--}}
<svg class="w-full h-auto max-w-md mx-auto" viewBox="0 0 480 320" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" aria-hidden="true">
    {{-- Outer frame: application platform container --}}
    <rect x="40" y="40" width="400" height="240" rx="12" stroke-width="1.5" opacity="0.4"/>
    <rect x="40" y="40" width="400" height="32" rx="12" stroke-width="1.5" opacity="0.5"/>
    <rect x="40" y="56" width="400" height="16" fill="currentColor" opacity="0.05"/>

    {{-- Window controls (top-left dots) --}}
    <circle cx="56" cy="56" r="3" stroke-width="1.5" opacity="0.6"/>
    <circle cx="68" cy="56" r="3" stroke-width="1.5" opacity="0.6"/>
    <circle cx="80" cy="56" r="3" stroke-width="1.5" opacity="0.6"/>

    {{-- Top bar title --}}
    <rect x="200" y="50" width="80" height="12" rx="2" stroke-width="1" opacity="0.4"/>

    {{-- Central security shield (authentication) --}}
    <g transform="translate(200, 130)">
        {{-- Shield outline --}}
        <path d="M 40 -30 L 40 30 Q 40 50 20 55 Q 0 50 0 30 L 0 -30 Q 20 -40 40 -30 Z"
              stroke-width="2" opacity="0.9"/>
        {{-- Shield inner fill --}}
        <path d="M 40 -30 L 40 30 Q 40 50 20 55 Q 0 50 0 30 L 0 -30 Q 20 -40 40 -30 Z"
              fill="currentColor" opacity="0.08"/>
        {{-- Checkmark inside shield --}}
        <path d="M 12 5 L 18 12 L 28 -2" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" opacity="0.95"/>
        {{-- Lock icon above shield --}}
        <rect x="14" y="-20" width="12" height="10" rx="1.5" stroke-width="1.5" opacity="0.7"/>
        <path d="M 16 -20 L 16 -25 Q 16 -28 20 -28 Q 24 -28 24 -25 L 24 -20" stroke-width="1.5" opacity="0.7"/>
    </g>

    {{-- Left card: User Management --}}
    <g transform="translate(70, 110)">
        <rect x="0" y="0" width="100" height="120" rx="8" stroke-width="1.5" opacity="0.5"/>
        <rect x="0" y="0" width="100" height="20" rx="8" stroke-width="1.5" opacity="0.6"/>
        {{-- Header dot --}}
        <circle cx="12" cy="10" r="3" stroke-width="1.5" opacity="0.7"/>
        <rect x="22" y="6" width="60" height="8" rx="2" stroke-width="1" opacity="0.4"/>

        {{-- User rows --}}
        <g transform="translate(10, 32)">
            {{-- User 1 --}}
            <circle cx="8" cy="8" r="6" stroke-width="1.5" opacity="0.7"/>
            <path d="M 4 14 Q 8 10 12 14" stroke-width="1.5" opacity="0.7"/>
            <rect x="22" y="4" width="60" height="4" rx="1" stroke-width="1" opacity="0.4"/>
            <rect x="22" y="11" width="40" height="3" rx="1" stroke-width="1" opacity="0.3"/>
            {{-- Active badge --}}
            <circle cx="86" cy="8" r="3" fill="currentColor" opacity="0.6"/>
        </g>
        <g transform="translate(10, 56)">
            <circle cx="8" cy="8" r="6" stroke-width="1.5" opacity="0.7"/>
            <path d="M 4 14 Q 8 10 12 14" stroke-width="1.5" opacity="0.7"/>
            <rect x="22" y="4" width="55" height="4" rx="1" stroke-width="1" opacity="0.4"/>
            <rect x="22" y="11" width="35" height="3" rx="1" stroke-width="1" opacity="0.3"/>
            <circle cx="86" cy="8" r="3" fill="currentColor" opacity="0.6"/>
        </g>
        <g transform="translate(10, 80)">
            <circle cx="8" cy="8" r="6" stroke-width="1.5" opacity="0.7"/>
            <path d="M 4 14 Q 8 10 12 14" stroke-width="1.5" opacity="0.7"/>
            <rect x="22" y="4" width="50" height="4" rx="1" stroke-width="1" opacity="0.4"/>
            <rect x="22" y="11" width="30" height="3" rx="1" stroke-width="1" opacity="0.3"/>
            <circle cx="86" cy="8" r="3" stroke-width="1.5" opacity="0.5"/>
        </g>
    </g>

    {{-- Right card: Role / Permission matrix --}}
    <g transform="translate(310, 110)">
        <rect x="0" y="0" width="100" height="120" rx="8" stroke-width="1.5" opacity="0.5"/>
        <rect x="0" y="0" width="100" height="20" rx="8" stroke-width="1.5" opacity="0.6"/>
        {{-- Header gear icon --}}
        <circle cx="12" cy="10" r="4" stroke-width="1.5" opacity="0.7"/>
        <path d="M 12 4 L 12 6 M 12 14 L 12 16 M 6 10 L 8 10 M 16 10 L 18 10" stroke-width="1.5" opacity="0.7"/>
        <rect x="22" y="6" width="60" height="8" rx="2" stroke-width="1" opacity="0.4"/>

        {{-- Role rows with permission toggles --}}
        <g transform="translate(10, 30)">
            {{-- Role label --}}
            <rect x="0" y="2" width="40" height="6" rx="2" stroke-width="1" opacity="0.5"/>
            {{-- Permission toggles (3 columns) --}}
            <rect x="50" y="0" width="10" height="10" rx="2" stroke-width="1.5" opacity="0.7"/>
            <path d="M 53 5 L 55 7 L 58 3" stroke-width="1.5" opacity="0.9"/>
            <rect x="66" y="0" width="10" height="10" rx="2" stroke-width="1.5" opacity="0.7"/>
            <path d="M 69 5 L 71 7 L 74 3" stroke-width="1.5" opacity="0.9"/>
            <rect x="82" y="0" width="10" height="10" rx="2" stroke-width="1.5" opacity="0.4"/>
        </g>
        <g transform="translate(10, 54)">
            <rect x="0" y="2" width="35" height="6" rx="2" stroke-width="1" opacity="0.5"/>
            <rect x="50" y="0" width="10" height="10" rx="2" stroke-width="1.5" opacity="0.7"/>
            <path d="M 53 5 L 55 7 L 58 3" stroke-width="1.5" opacity="0.9"/>
            <rect x="66" y="0" width="10" height="10" rx="2" stroke-width="1.5" opacity="0.4"/>
            <rect x="82" y="0" width="10" height="10" rx="2" stroke-width="1.5" opacity="0.4"/>
        </g>
        <g transform="translate(10, 78)">
            <rect x="0" y="2" width="45" height="6" rx="2" stroke-width="1" opacity="0.5"/>
            <rect x="50" y="0" width="10" height="10" rx="2" stroke-width="1.5" opacity="0.7"/>
            <path d="M 53 5 L 55 7 L 58 3" stroke-width="1.5" opacity="0.9"/>
            <rect x="66" y="0" width="10" height="10" rx="2" stroke-width="1.5" opacity="0.7"/>
            <path d="M 69 5 L 71 7 L 74 3" stroke-width="1.5" opacity="0.9"/>
            <rect x="82" y="0" width="10" height="10" rx="2" stroke-width="1.5" opacity="0.7"/>
            <path d="M 85 5 L 87 7 L 90 3" stroke-width="1.5" opacity="0.9"/>
        </g>
    </g>

    {{-- Connection lines: cards <-> central shield --}}
    <path d="M 170 170 Q 185 165 200 160" stroke-width="1" opacity="0.3" stroke-dasharray="3 3"/>
    <path d="M 310 170 Q 295 165 280 160" stroke-width="1" opacity="0.3" stroke-dasharray="3 3"/>

    {{-- Bottom status bar --}}
    <rect x="60" y="250" width="360" height="6" rx="3" stroke-width="1" opacity="0.3"/>
    <rect x="60" y="250" width="120" height="6" rx="3" fill="currentColor" opacity="0.4"/>

    {{-- Decorative corner accents --}}
    <path d="M 40 80 L 40 60 L 60 60" stroke-width="2" opacity="0.6"/>
    <path d="M 440 80 L 440 60 L 420 60" stroke-width="2" opacity="0.6"/>
    <path d="M 40 240 L 40 260 L 60 260" stroke-width="2" opacity="0.6"/>
    <path d="M 440 240 L 440 260 L 420 260" stroke-width="2" opacity="0.6"/>
</svg>
