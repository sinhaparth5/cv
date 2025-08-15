<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

if ($_SERVER['REQUEST_URI'] === '/api/data') {
    header('Content-Type: application/json');
    echo json_encode(['message' => 'Hello from PHP!', 'time' => date('H:i:s')]);
    exit;
}

$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);

$twig = Twig::create(__DIR__ . '/../templates', ['cache' => false, 'debug' => true]);
$app->add(TwigMiddleware::create($app, $twig));

$app->get('/', function ($request, $response, $args) {
    $view = Twig::fromRequest($request);
    
    $seo = [
        'title' => 'Parth Sinha - Full Stack Engineer',
        'description' => 'Detail-oriented Full Stack Engineer dedicated to building high-quality products. Specializing in modern web technologies and scalable solutions.',
        'keywords' => 'Full Stack Engineer, Web Developer, PHP, JavaScript, React, Node.js, Software Engineer',
        'author' => 'Parth Sinha',
        'url' => 'https://cv.parthsinha.com',
        'image' => 'https://' . $_SERVER['HTTP_HOST'] . '/assets/images/profile.webp',
        'type' => 'profile',
        'locale' => 'en_US',
        'site_name' => 'Parth Sinha Portfolio'
    ];
    
    $workExperience = [
        [
            'company' => 'Motion',
            'url' => 'https://motionapp.com/',
            'position' => 'Senior Software Engineer',
            'period' => '2025 - Present',
            'description' => 'Working on internal AI agents platform allowing marketing specialists to create AI workflows.',
            'tags' => ['Remote', 'AI', 'React', 'Next.js', 'TypeScript', 'AdonisJS']
        ],
        [
            'company' => 'Film.io',
            'url' => 'https://film.io',
            'position' => 'Software Architect',
            'period' => '2024 - 2025',
            'description' => 'Leading technical architecture of a blockchain-based film funding platform.',
            'details' => [
                'Architecting migration from CRA to Next.js for improved performance, SEO, and DX',
                'Established release process enabling faster deployments and reliable rollbacks',
                'Implementing system-wide monitoring and security improvements'
            ],
            'tags' => ['Remote', 'React', 'Next.js', 'TypeScript', 'Node.js']
        ],
        [
            'company' => 'Parabol',
            'url' => 'https://parabol.co',
            'position' => 'Senior Full Stack Developer',
            'period' => '2021 - 2024',
            'description' => 'Senior developer and squad leader for an enterprise agile meeting platform.',
            'details' => [
                'Built design system with Tailwind CSS, improving development speed and time to market',
                'Implemented engineering practices: PR automation, code review guidelines, and workflows',
                'Open source contributions to Relay DevTools and React i18n tooling'
            ],
            'tags' => ['Remote', 'React', 'TypeScript', 'Node.js', 'GraphQL', 'Tailwind CSS']
        ],
        [
            'company' => 'Clevertech',
            'url' => 'https://clevertech.biz',
            'position' => 'Lead Android Developer → Full Stack Developer',
            'period' => '2015 - 2021',
            'description' => 'Successfully transitioned from mobile to full-stack development while leading distributed teams.',
            'details' => [
                'Led frontend team at Evercast, building real-time platform supporting 30+ users per room with HD streaming and collaboration tools',
                'Developed offline-first Android app for DKMS, improving donor registration process',
                'Led development teams across multiple successful client projects'
            ],
            'tags' => ['Remote', 'React', 'TypeScript', 'Node.js', 'Android', 'Kotlin']
        ],
        [
            'company' => 'Jojo Mobile',
            'url' => 'https://bsgroup.eu/',
            'position' => 'Android Developer → Lead Android Developer',
            'period' => '2012 - 2015',
            'description' => 'First Android developer, grew and led a team of 15+ engineers while establishing engineering culture.',
            'details' => [
                'Developed apps for major Polish companies including LOT, Polskie Radio, and Agora',
                'Built and mentored high-performing mobile development team'
            ],
            'tags' => ['On Site', 'Android', 'Java', 'Kotlin']
        ],
        [
            'company' => 'Nokia Siemens Networks',
            'url' => 'https://www.nokia.com',
            'position' => 'C/C++ Developer',
            'period' => '2010 - 2012',
            'description' => 'Developed software for LTE base stations at enterprise scale, gaining strong fundamentals in software architecture, testing practices, and cross-team collaboration.',
            'tags' => ['On Site', 'C/C++', 'LTE', 'Agile']
        ]
    ];
    
    $skills = [
        'React/Next.js/Remix', 'TypeScript', 'Tailwind CSS', 'Design Systems', 
        'WebRTC', 'WebSockets', 'Node.js', 'GraphQL', 'Relay', 
        'System Architecture', 'Remote Team Leadership'
    ];
    
    $sideProjects = [
        [
            'name' => 'Monito',
            'url' => 'https://monito.dev/',
            'description' => 'Browser extension for debugging web applications. Includes taking screenshots, screen recording, E2E tests generation and generating bug reports',
            'technologies' => ['TypeScript', 'Next.js', 'Browser Extension', 'PostgreSQL'],
            'active' => true
        ],
        [
            'name' => 'Consultly',
            'url' => 'https://consultly.com/',
            'description' => 'Platform for online consultations with real-time video meetings and scheduling',
            'technologies' => ['TypeScript', 'Next.js', 'Vite', 'GraphQL', 'WebRTC', 'Tailwind CSS', 'PostgreSQL', 'Redis'],
            'active' => true
        ],
        [
            'name' => 'Minimalist CV',
            'url' => 'https://github.com/BartoszJarocki/cv',
            'description' => 'An open source minimalist, print friendly CV template with a focus on readability and clean design. >9k stars on GitHub',
            'technologies' => ['TypeScript', 'Next.js', 'Tailwind CSS'],
            'active' => true
        ]
    ];
    
    $education = [
        [
            'institution' => 'Wrocław University of Technology',
            'period' => '2007 - 2010',
            'degree' => 'Bachelor\'s Degree in Control systems engineering and Robotics'
        ]
    ];
    
    $data = [
        'seo' => $seo,
        'profile' => [
            'name' => 'Parth Sinha',
            'description' => 'Detail-oriented Full Stack Engineer dedicated to building high-quality products.',
            'location' => 'Oxford, United Kingdom',
            'about' => 'Frontend-focused Full Stack Engineer specializing in high-performance React applications, scalable Node.js services, and real-time collaboration systems. Experienced in technical architecture design and remote team leadership.'
        ],
        'workExperience' => $workExperience,
        'skills' => $skills,
        'sideProjects' => $sideProjects,
        'education' => $education
    ];
    
    return $view->render($response, 'index.twig', $data);
});

$app->get('/{path:.*}', function ($request, $response, $args) {
    return $response->withHeader('Location', '/')->withStatus(302);
});

$app->run();