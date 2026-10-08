'use client'

import { useEffect, useState } from 'react'
import Link from 'next/link'
import { usePathname } from 'next/navigation'
import { AnimatePresence, motion } from 'framer-motion'
import { Menu, X } from 'lucide-react'
import { Button } from '@/components/ui/button'
import { SiteLogo } from '@/components/site-logo'
import { cn } from '@/lib/utils'

const LINKS = [
  { label: 'Home', href: '/' },
  { label: 'Solutions', href: '/solutions' },
  { label: 'Projects', href: '/projects' },
  { label: 'About', href: '/about' },
  { label: 'Why SAC', href: '/why-sac' },
  { label: 'Careers', href: '/careers' },
  { label: 'Contact', href: '/contact' },
]

export function Navbar() {
  const pathname = usePathname()
  const isHome = pathname === '/'
  const [scrolled, setScrolled] = useState(false)
  const [open, setOpen] = useState(false)

  useEffect(() => {
    const onScroll = () => setScrolled(window.scrollY > 24)

    onScroll()

    window.addEventListener('scroll', onScroll, {
      passive: true,
    })

    return () => window.removeEventListener('scroll', onScroll)
  }, [])

  useEffect(() => {
    document.body.style.overflow = open ? 'hidden' : ''

    return () => {
      document.body.style.overflow = ''
    }
  }, [open])

  // Solid background on every interior page,
  // and on the home page once scrolled.
  const solid = !isHome || scrolled

  return (
    <header
      className={cn(
        'fixed inset-x-0 top-0 z-50 border-b bg-background transition-shadow duration-300',
        solid
          ? 'border-border shadow-[0_2px_12px_-4px_rgb(0_0_0/0.12)]'
          : 'border-border/60 shadow-none',
      )}
    >
      <nav className="mx-auto flex h-16 max-w-7xl items-center justify-between gap-6 px-4 sm:h-20 sm:px-6 lg:h-24 lg:px-8">

        {/* LOGO */}
        <SiteLogo priority />

        {/* DESKTOP NAVIGATION */}
        <ul className="hidden items-center gap-1 lg:flex">
          {LINKS.map((link) => {
            const active =
              link.href === '/'
                ? pathname === '/'
                : pathname.startsWith(link.href)

            return (
              <li key={link.href}>
                <Link
                  href={link.href}
                  className={cn(
                    'rounded-md px-3 py-2 text-sm font-medium transition-colors',
                    active
                      ? 'text-primary'
                      : 'text-muted-foreground hover:text-foreground',
                  )}
                >
                  {link.label}
                </Link>
              </li>
            )
          })}
        </ul>

        {/* DESKTOP CTA */}
        <div className="hidden items-center gap-3 lg:flex">
          <Button
            nativeButton={false}
            render={
              <Link href="/contact">
                Get a Consultation
              </Link>
            }
          />
        </div>

        {/* MOBILE MENU BUTTON */}
        <div className="flex items-center gap-2 lg:hidden">
          <button
            type="button"
            onClick={() => setOpen(true)}
            className="inline-flex items-center justify-center rounded-md p-2 text-foreground"
            aria-label="Open menu"
          >
            <Menu className="h-6 w-6" />
          </button>
        </div>

      </nav>

      {/* MOBILE NAVIGATION */}
      <AnimatePresence>
        {open && (
          <>
            {/* BACKDROP */}
            <motion.div
              className="fixed inset-0 z-50 h-[100dvh] w-screen bg-background/70 backdrop-blur-sm lg:hidden"
              initial={{ opacity: 0 }}
              animate={{ opacity: 1 }}
              exit={{ opacity: 0 }}
              onClick={() => setOpen(false)}
            />

            {/* MOBILE SIDEBAR */}
            <motion.aside
              className="fixed inset-y-0 right-0 z-[60] flex h-[100dvh] w-72 max-w-[80vw] flex-col gap-2 overflow-y-auto border-l border-black/10 bg-[#c8f0d0] p-6 text-black shadow-xl lg:hidden"
              initial={{ x: '100%' }}
              animate={{ x: 0 }}
              exit={{ x: '100%' }}
              transition={{
                type: 'spring',
                damping: 30,
                stiffness: 300,
              }}
            >
              {/* MOBILE HEADER */}
              <div className="mb-4 flex items-center justify-between">
                <SiteLogo variant="menu" />

                <button
                  type="button"
                  onClick={() => setOpen(false)}
                  className="rounded-md p-2 text-black"
                  aria-label="Close menu"
                >
                  <X className="h-6 w-6" />
                </button>
              </div>

              {/* MOBILE LINKS */}
              {LINKS.map((link) => {
                const active =
                  link.href === '/'
                    ? pathname === '/'
                    : pathname.startsWith(link.href)

                return (
                  <Link
                    key={link.href}
                    href={link.href}
                    onClick={() => setOpen(false)}
                    className={cn(
                      'rounded-md px-3 py-3 text-base font-medium text-black transition-colors hover:bg-primary-foreground/20 hover:text-black',
                      active
                        ? 'bg-primary-foreground/25 text-black'
                        : '',
                    )}
                  >
                    {link.label}
                  </Link>
                )
              })}

              {/* MOBILE CTA */}
              <Button
                className="mt-4 bg-black text-white hover:bg-black/80"
                nativeButton={false}
                render={
                  <Link
                    href="/contact"
                    onClick={() => setOpen(false)}
                  >
                    Get a Consultation
                  </Link>
                }
              />
            </motion.aside>
          </>
        )}
      </AnimatePresence>
    </header>
  )
}
