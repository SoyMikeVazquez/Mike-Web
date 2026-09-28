import re

file_path = 'index.html'
with open(file_path, 'r', encoding='utf-8') as file:
    content = file.read()

# I will add an extremely aggressive CSS rule block for max-width 991px right before the closing </style>
aggressive_css = '''
    /* FORCE EVERYTHING VERTICAL ON TABLET/MOBILE */
    @media screen and (max-width: 991px) {
        .w-row, 
        .div-block-19, 
        .div-block-253, 
        .c-nav-content, 
        .card-content, 
        .wrapper-3.home, 
        .container.blog,
        .div-block-225 {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            width: 100% !important;
            text-align: center !important;
        }
        
        .c-nav-content {
            flex-direction: row !important; /* Keep nav horizontal */
            justify-content: space-between !important;
        }

        .div-block-228, .text-block-26, .text-block-8, .paragraph-5, .paragraph-7 {
            text-align: center !important;
            width: 100% !important;
            max-width: 100% !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }
        
        .w-col {
            width: 100% !important;
            max-width: 100% !important;
            margin-bottom: 25px !important;
        }

        /* Fix image cards inside sticky-card */
        .card-content-left, .card-content-right {
            width: 100% !important;
            max-width: 100% !important;
            padding: 15px !important;
            text-align: center !important;
        }
        
        .sticky-card__image {
            max-width: 100% !important;
            height: auto !important;
            margin: 0 auto !important;
        }
        
        /* Stop shrinking */
        .text-block-26, .text-block-10, .text-block-8, .div-block-228 {
            white-space: normal !important;
            min-width: 0 !important;
        }
        
        /* Adjust Proyectos grid if it exists */
        .w-layout-grid {
            display: flex !important;
            flex-direction: column !important;
        }
        
        /* The container for each BASE project */
        .container-53.w-container > div {
             flex-direction: column !important;
        }
    }
'''

# Find the last closing style tag and insert the aggressive_css right before it
content = content.replace('</style>', aggressive_css + '\n</style>', 1)

with open(file_path, 'w', encoding='utf-8') as file:
    file.write(content)

print("Aggressive vertical CSS applied safely without deleting content.")
