import type { ComponentType, SVGProps } from 'react'
import Link from 'next/link'
import { Phone, Mail } from 'lucide-react'
import { SiteLogo } from '@/components/site-logo'

function LinkedInIcon(props: SVGProps<SVGSVGElement>) {
  return (
    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" {...props}>
      <path d="M20.45 20.45h-3.56v-5.57c0-1.33-.02-3.04-1.85-3.04-1.85 0-2.13 1.45-2.13 2.94v5.67H9.35V9h3.42v1.56h.05c.48-.9 1.64-1.85 3.37-1.85 3.6 0 4.27 2.37 4.27 5.46v6.28zM5.34 7.43a2.07 2.07 0 1 1 0-4.14 2.07 2.07 0 0 1 0 4.14zM7.12 20.45H3.55V9h3.57v11.45zM22.22 0H1.77C.79 0 0 .77 0 1.72v20.56C0 23.23.79 24 1.77 24h20.45c.98 0 1.78-.77 1.78-1.72V1.72C24 .77 23.2 0 22.22 0z" />
    </svg>
  )
}

function XIcon(props: SVGProps<SVGSVGElement>) {
  return (
    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" {...props}>
      <path d="M18.24 2.25h3.31l-7.23 8.26L23 21.75h-6.63l-5.2-6.79-5.95 6.79H1.9l7.73-8.84L1 2.25h6.8l4.7 6.21 5.74-6.21zm-1.16 17.52h1.83L7.02 4.13H5.06l12.02 15.64z" />
    </svg>
  )
}

function FacebookIcon(props: SVGProps<SVGSVGElement>) {
  return (
    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" {...props}>
      <path d="M24 12.07C24 5.4 18.63 0 12 0S0 5.4 0 12.07C0 18.1 4.39 23.1 10.13 24v-8.44H7.08v-3.49h3.05V9.41c0-3.02 1.79-4.69 4.53-4.69 1.31 0 2.68.24 2.68.24v2.97h-1.51c-1.49 0-1.96.93-1.96 1.89v2.25h3.33l-.53 3.49h-2.8V24C19.61 23.1 24 18.1 24 12.07z" />
    </svg>
  )
}

const QUICK_LINKS = [
  { label: 'Home', href: '/' },
  { label: 'About', href: '/about' },
  { label: 'Solutions', href: '/solutions' },
  { label: 'Projects', href: '/projects' },
  { label: 'Why SAC', href: '/why-sac' },
  { label: 'Careers', href: '/careers' },
  { label: 'Contact', href: '/contact' },
]

const SERVICES = [
  {
    label: 'IP Video Surveillance',
    href: '/solutions#ip-video-surveillance',
  },
  {
    label: 'Access Control',
    href: '/solutions#access-control',
  },
  {
    label: 'Fire Detection & Suppression',
    href: '/solutions#fire-detection',
  },
  {
    label: 'Building Management Systems',
    href: '/solutions#building-management',
  },
  {
    label: 'IT Networking & Wi-Fi',
    href: '/solutions#it-networking',
  },
  {
    label: 'PAGA & PIDS',
    href: '/solutions#paga-pids',
  },
]

export function SiteFooter() {
  return (
    <footer className="border-t border-border bg-background">
      <div className="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">

        <div className="grid gap-10 md:grid-cols-2 lg:grid-cols-4">

          {/* COMPANY */}
          <div>
            <SiteLogo variant="footer" className="w-fit" />

            <p className="mt-4 max-w-xs text-sm leading-relaxed text-muted-foreground">
              Engineering trust since 2010 &mdash; tailor-made Building
              Security, Management &amp; Automation for India&apos;s most
              demanding facilities.
            </p>

            <div className="mt-5 flex gap-3">
              {(
                [
                  {
                    icon: LinkedInIcon,
                    label: 'LinkedIn',
                  },
                  {
                    icon: XIcon,
                    label: 'X',
                  },
                  {
                    icon: FacebookIcon,
                    label: 'Facebook',
                  },
                ] as {
                  icon: ComponentType<SVGProps<SVGSVGElement>>
                  label: string
                }[]
              ).map(({ icon: Icon, label }) => (
                <a
                  key={label}
                  href="#"
                  aria-label={label}
                  className="flex h-9 w-9 items-center justify-center rounded-md border border-border text-muted-foreground transition-colors hover:border-primary hover:text-primary"
                >
                  <Icon className="h-4 w-4" />
                </a>
              ))}
            </div>
          </div>

          {/* QUICK LINKS */}
          <div>
            <h3 className="text-sm font-semibold uppercase tracking-wider">
              Quick Links
            </h3>

            <ul className="mt-4 space-y-2.5">
              {QUICK_LINKS.map((link) => (
                <li key={link.href}>
                  <Link
                    href={link.href}
                    className="text-sm text-muted-foreground transition-colors hover:text-foreground"
                  >
                    {link.label}
                  </Link>
                </li>
              ))}
            </ul>
          </div>

          {/* SERVICES */}
          <div>
            <h3 className="text-sm font-semibold uppercase tracking-wider">
              Services
            </h3>

            <ul className="mt-4 space-y-2.5">
              {SERVICES.map((service) => (
                <li
                  key={service.href}
                  className="text-sm text-muted-foreground"
                >
                  <Link
                    href={service.href}
                    className="cursor-pointer transition-colors hover:text-foreground focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary"
                  >
                    {service.label}
                  </Link>
                </li>
              ))}
            </ul>
          </div>

          {/* GET IN TOUCH */}
          <div>
            <h3 className="text-sm font-semibold uppercase tracking-wider">
              Get in Touch
            </h3>

            <ul className="mt-4 space-y-3">

              {/* PHONE 1 */}
              <li className="flex items-start gap-2.5 text-sm text-muted-foreground">
                <Phone className="mt-0.5 h-4 w-4 shrink-0 text-primary" />

                <a
                  href="tel:+919352970001"
                  className="transition-colors hover:text-primary"
                >
                  +91 93529 70001
                </a>
              </li>

              {/* PHONE 2 */}
              <li className="flex items-start gap-2.5 text-sm text-muted-foreground">
                <Phone className="mt-0.5 h-4 w-4 shrink-0 text-primary" />

                <a
                  href="tel:+919829084113"
                  className="transition-colors hover:text-primary"
                >
                  +91 98290 84113
                </a>
              </li>

              {/* EMAIL 1 */}
              <li className="flex items-start gap-2.5 text-sm text-muted-foreground">
                <Mail className="mt-0.5 h-4 w-4 shrink-0 text-primary" />

                <a
                  href="mailto:ag@sacindia.co.in"
                  className="transition-colors hover:text-primary"
                >
                  ag@sacindia.co.in
                </a>
              </li>

              {/* EMAIL 2 */}
              <li className="flex items-start gap-2.5 text-sm text-muted-foreground">
                <Mail className="mt-0.5 h-4 w-4 shrink-0 text-primary" />

                <a
                  href="mailto:am@sacindia.co.in"
                  className="transition-colors hover:text-primary"
                >
                  am@sacindia.co.in
                </a>
              </li>

              {/* ADDRESS */}
              <li className="text-sm leading-relaxed text-muted-foreground">
                Plot No. C-5/2, Chitrakoot Scheme,
                <br />
                Ajmer Road, Jaipur &ndash; 302021
              </li>

            </ul>
          </div>

        </div>

        {/* BOTTOM */}
        <div className="mt-12 flex flex-col items-center justify-between gap-3 border-t border-border pt-6 text-sm text-muted-foreground sm:flex-row">

          <p>
            &copy; {new Date().getFullYear()} Secure Automation Consultants.
            All rights reserved.
          </p>

          <p>Jaipur, Rajasthan, India</p>

        </div>

      </div>
    </footer>
  )
}
