# Laravel + Vue 3 Learning Project

A learning playground to understand how Laravel, Vue 3, and Inertia.js work together. **UI is intentionally minimal** - the focus is on backend/frontend integration, not design.

## What This Is

- ✍️ A personal learning project for exploring Laravel + Vue 3 integration
- 🎯 Simplified task management app (create, edit, delete, filter)
- 💪 Fully functional but not production-ready
- 📚 Example of real patterns: Inertia Form component, type-safe routes, server validation

## 🛠️ Tech Stack

- **Backend**: Laravel 12
- **Frontend**: Vue 3 + TypeScript
- **Bridge**: Inertia.js v2 (no API, just server-rendered)
- **Routes**: Wayfinder (auto-generated TS action files)
- **UI**: Shadcn-ui + Lucide icons
- **Tables**: TanStack Vue Table
- **Styling**: Tailwind CSS v4
- **Builds**: Vite
- **Auth**: Laravel Fortify (built-in)

### ✅ Features

- User auth (register, login, logout, 2FA)
- Task CRUD with server-side validation
- Search & filtering with router
- Authorization policies
- Type-safe form handling with Inertia

## 💡 What I Learned

- **Inertia Form component** - How slots expose form state (`errors`, `processing`)
- **Wayfinder** - Auto-generated type-safe route helpers from Laravel
- **Server-side rendering** - Rendering Vue on backend, sending HTML to client
- **Form validation** - Server validation → reactive error display in Vue
- **Authorization** - Policies to check permissions before mutations
- **Accessible UI** - Building with Shadcn-UI primitives instead of reinventing

## Notes

- This is done. No further changes planned.
- Not meant for production - it's a learning exercise.
- The code can definitely be improved, but it works and teaches the concepts.

## 🔗 Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Vue 3 Documentation](https://vuejs.org/guide/introduction.html)
- [Inertia.js Documentation](https://inertiajs.com)
- [TypeScript Documentation](https://www.typescriptlang.org/docs/)

## 📄 License

This is a personal learning project.
