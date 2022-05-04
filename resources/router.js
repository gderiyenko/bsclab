import VueRouter from 'vue-router'

// Pages
import Home from './js/pages/Home'
import Login from './js/pages/Login'
import Users from './js/pages/users/Index'
import UsersCreate from './js/pages/users/Create'
import UsersEdit from './js/pages/users/Edit'
import UsersLog from './js/pages/users/Log'
import Firms from './js/pages/firms/Index'
import FirmsShow from './js/pages/firms/Show'
import FirmsCreate from './js/pages/firms/Create'
import FirmsEdit from './js/pages/firms/Edit'
import FirmsFiles from './js/pages/files/Show'
import Invoices from './js/pages/invoices/Index'
import InvoicesShow from './js/pages/invoices/Show'
import InvoicesCreate from './js/pages/invoices/Create'
import InvoicesEdit from './js/pages/invoices/Edit'
import Acts from './js/pages/acts/Index'
import ActsShow from './js/pages/acts/Show'
import ActsCreate from './js/pages/acts/Create'
import ActsEdit from './js/pages/acts/Edit'
import Payments from './js/pages/payments/Index'
import PaymentsShow from './js/pages/payments/Show'
import PaymentsCreate from './js/pages/payments/Create'
import PaymentsEdit from './js/pages/payments/Edit'
import Templates from './js/pages/templates/Index'
import TemplatesCreate from './js/pages/templates/Create'
import TemplatesEdit from './js/pages/templates/Edit'
import Contracts from './js/pages/contracts/Index'
import ContractsShow from './js/pages/contracts/Show'
import ContractsCreate from './js/pages/contracts/Create'
import ContractsEdit from './js/pages/contracts/Edit'
import Services from './js/pages/services/Index'
import ServicesCreateMaterial from './js/pages/services/CreateMaterial'
import ServicesCreateCharacteristic from './js/pages/services/CreateCharacteristic'
import ServicesEdit from './js/pages/services/Edit'

// Routes
const routes = [
    {
        path: '/',
        name: 'home',
        component: Home,
        meta: {
            auth: true
        }
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            auth: false
        }
    },

    // USERS ROUTES
    {
        path: '/users',
        name: 'users',
        component: Users,
        meta: {
            auth: {
                roles: ['admin'],
                redirect: {
                    name: 'login'
                },
                forbiddenRedirect: '/403'
            }
        }
    },
    {
        path: '/users/create',
        name: 'users.create',
        component: UsersCreate
    },
    {
        path: '/users/edit/:id',
        name: 'users.edit',
        component: UsersEdit
    },
    {
        path: '/users/log',
        name: 'users.log',
        component: UsersLog
    },

    // FIRMS ROUTES
    {
        path: '/firms',
        name: 'firms',
        component: Firms,
        meta: {
            auth: {
                roles: ['admin', 'accountant', 'worker'],
                redirect: {
                    name: 'login'
                },
                forbiddenRedirect: '/403'
            }
        }
    },
    {
        path: '/firms/show/:id',
        name: 'firms.show',
        component: FirmsShow
    },
    {
        path: '/firms/create',
        name: 'firms.create',
        component: FirmsCreate,
        meta: {
            auth: {
                roles: ['admin', 'accountant'],
                redirect: {
                    name: 'firms'
                },
            }
        }
    },
    {
        path: '/firms/edit/:id',
        name: 'firms.edit',
        component: FirmsEdit,
        meta: {
            auth: {
                roles: ['admin', 'accountant'],
                redirect: {
                    name: 'firms'
                },
            }
        }
    },

    // CONTRACTS ROUTES
    {
        path: '/contracts',
        name: 'contracts',
        component: Contracts,
        meta: {
            auth: {
                roles: ['admin', 'accountant', 'worker'],
                redirect: {
                    name: 'login'
                },
                forbiddenRedirect: '/403'
            }
        }
    },
    {
        path: '/contracts/show/:id',
        name: 'contracts.show',
        component: ContractsShow,
    },
    {
        path: '/contracts/:firm_id/create',
        name: 'contracts.create',
        component: ContractsCreate,
        props: true,
        meta: {
            auth: {
                roles: ['admin', 'accountant'],
                redirect: {
                    name: 'contracts'
                },
            }
        }
    },
    {
        path: '/contracts/edit/:id',
        name: 'contracts.edit',
        component: ContractsEdit,
        meta: {
            auth: {
                roles: ['admin', 'accountant'],
                redirect: {
                    name: 'contracts'
                },
            }
        }
    },

    // INVOICES ROUTES
    {
        path: '/invoices',
        name: 'invoices',
        component: Invoices,
        meta: {
            auth: {
                roles: ['admin', 'accountant', 'worker'],
                redirect: {
                    name: 'login'
                },
                forbiddenRedirect: '/403'
            }
        }
    },
    {
        path: '/invoices/show/:id',
        name: 'invoices.show',
        component: InvoicesShow,
    },
    {
        path: '/invoices/:firm_id/create',
        name: 'invoices.create',
        component: InvoicesCreate,
        props: true,
        meta: {
            auth: {
                roles: ['admin', 'accountant'],
                redirect: {
                    name: 'invoices'
                },
            }
        }
    },
    {
        path: '/invoices/edit/:id',
        name: 'invoices.edit',
        component: InvoicesEdit,
        meta: {
            auth: {
                roles: ['admin', 'accountant'],
                redirect: {
                    name: 'invoices'
                },
            }
        }
    },

    // ACTS ROUTES
    {
        path: '/acts',
        name: 'acts',
        component: Acts,
        meta: {
            auth: {
                roles: ['admin', 'accountant', 'worker'],
                redirect: {
                    name: 'login'
                },
                forbiddenRedirect: '/403'
            }
        }
    },
    {
        path: '/acts/show/:id',
        name: 'acts.show',
        component: ActsShow,
    },
    {
        path: '/acts/:firm_id/create',
        name: 'acts.create',
        component: ActsCreate,
        props: true,
        meta: {
            auth: {
                roles: ['admin', 'accountant'],
                redirect: {
                    name: 'acts'
                },
            }
        }
    },
    {
        path: '/acts/edit/:id',
        name: 'acts.edit',
        component: ActsEdit,
        meta: {
            auth: {
                roles: ['admin', 'accountant'],
                redirect: {
                    name: 'acts'
                },
            }
        }
    },

    // DOCUMENTS ROUTES
    {
        path: '/files/show/:id',
        name: 'files.show',
        component: FirmsFiles,
        props: true,
        meta: {
            auth: {
                roles: ['admin', 'accountant', 'worker'],
                redirect: {
                    name: 'login'
                },
                forbiddenRedirect: '/403'
            }
        }
    },

    // SERVICES ROUTES
    {
        path: '/services',
        name: 'services',
        component: Services,
        props: true,
        meta: {
            auth: {
                roles: ['admin', 'accountant', 'worker'],
                redirect: {
                    name: 'login'
                },
                forbiddenRedirect: '/403'
            }
        }
    },
    {
        path: '/services/create',
        name: 'services.create.material',
        component: ServicesCreateMaterial,
        meta: {
            auth: {
                roles: ['admin', 'accountant'],
                redirect: {
                    name: 'services'
                },
            }
        }
    },
    {
        path: '/services/create',
        name: 'services.create.сharacteristic',
        component: ServicesCreateCharacteristic,
        meta: {
            auth: {
                roles: ['admin', 'accountant'],
                redirect: {
                    name: 'services'
                },
            }
        }
    },
    {
        path: '/services/edit/:id',
        name: 'services.edit',
        component: ServicesEdit,
        meta: {
            auth: {
                roles: ['admin', 'accountant'],
                redirect: {
                    name: 'services'
                },
            }
        }
    },

    // PAYMENTS ROUTES
    {
        path: '/payments',
        name: 'payments',
        component: Payments,
        props: true,
        meta: {
            auth: {
                roles: ['admin', 'accountant', 'worker'],
                redirect: {
                    name: 'login'
                },
                forbiddenRedirect: '/403'
            }
        }
    },
    {
        path: '/payments/show/:id',
        name: 'payments.show',
        component: PaymentsShow,
    },
    {
        path: '/payments/:firm_id/create',
        name: 'payments.create',
        component: PaymentsCreate,
        props: true,
        meta: {
            auth: {
                roles: ['admin', 'accountant'],
                redirect: {
                    name: 'payments'
                },
            }
        }
    },
    {
        path: '/payments/edit/:id',
        name: 'payments.edit',
        component: PaymentsEdit,
        meta: {
            auth: {
                roles: ['admin', 'accountant'],
                redirect: {
                    name: 'payments'
                },
            }
        }
    },

    // TEMPLATES ROUTES
    {
        path: '/templates',
        name: 'templates',
        component: Templates,
        meta: {
            auth: {
                roles: ['admin', 'accountant', 'worker'],
                redirect: {
                    name: 'login'
                },
                forbiddenRedirect: '/403'
            }
        }
    },
    {
        path: '/templates/create',
        name: 'templates.create',
        component: TemplatesCreate,
        meta: {
            auth: {
                roles: ['admin', 'accountant'],
                redirect: {
                    name: 'templates'
                },
            }
        }
    },
    {
        path: '/templates/edit/:id',
        name: 'templates.edit',
        component: TemplatesEdit,
        meta: {
            auth: {
                roles: ['admin', 'accountant'],
                redirect: {
                    name: 'templates'
                },
            }
        }
    },

    // FALSE ROUTES
    {
        path: "*",
        redirect: "/"
    }
]
const router = new VueRouter({
    history: true,
    mode: 'history',
    routes,
})
export default router
