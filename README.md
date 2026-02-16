# Laravel + Vue 3 Learning Project

A minimalist full-stack web application built to understand how Laravel, Vue 3, and Inertia.js work together seamlessly.

## 📚 Project Purpose

This project is a **learning exercise** designed to explore the integration of three powerful technologies:

- **Laravel** - PHP backend framework for building robust server-side logic
- **Vue 3** - Modern JavaScript framework for creating interactive user interfaces
- **Inertia.js** - Adapter that bridges Laravel and Vue 3, eliminating the need for a separate API

The UI is intentionally kept **minimal and functional**, focusing on core concepts rather than aesthetics. The goal is to understand how these technologies communicate and work as a cohesive unit.

## 🛠️ Tech Stack

- **Backend**: Laravel 12 (Official Vue Starter Kit)
- **Frontend**: Vue 3 with TypeScript
- **Bridge**: Inertia.js
- **Build Tool**: Vite
- **Authentication**: Laravel Fortify (built-in with starter kit)
- **UI Components**: shadcn-vue
- **Styling**: Tailwind CSS

## 📋 Project Status

**Current Stage**: Early development - Basic CRUD operations

### Completed Features

- ✅ User authentication (register, login, logout)
- ✅ Task creation (store)
- ✅ Task listing with ordering
- ✅ Task editing with form population
- ✅ Data validation on request layer
- ✅ Form state management with Inertia useForm()

### In Progress / Planned

- 🔄 Form Vaildation
- 🔄 Task filtering and search
- 🔄 Policy authorization
- 🔄 Advanced validation rules
- 🔄 Error handling and notifications

## 💡 Learning Focus

This project demonstrates:

1. **Server-Rendered Components**: How Inertia.js renders Vue components on the server
2. **Reactive Form Handling**: Managing form state and validation in Vue
3. **Type Safety**: Using TypeScript across frontend and generating types from backend
4. **Routing**: Laravel routes mapped to Vue page components
5. **Authentication**: Protecting routes and managing user sessions
6. **Validation**: Server-side validation in Laravel Form Requests
7. **Data Flow**: How data flows from database → controller → Vue component

## 🎯 Key Concepts Explored

- **Inertia.js Integration**: Monolithic application without API separation
- **Reactive Data Binding**: Vue 3's composition API with `useForm()`
- **Database Queries**: Eloquent ORM and query optimization
- **Middleware**: Route protection and authentication checks
- **Type Definitions**: PHP properties reflected as TypeScript types

## 📝 Notes

- This is **not a production-ready** application
- Security features are minimal (authorization policies incomplete)
- UI design is intentionally basic - focus is on functionality
- Each completed feature builds upon previous learning

## 🔗 Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Vue 3 Documentation](https://vuejs.org/guide/introduction.html)
- [Inertia.js Documentation](https://inertiajs.com)
- [TypeScript Documentation](https://www.typescriptlang.org/docs/)

## 📄 License

This is a personal learning project.
