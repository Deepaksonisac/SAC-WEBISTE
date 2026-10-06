'use client'

import { useState, type FormEvent } from 'react'
import { Phone, Mail, MapPin, CheckCircle2 } from 'lucide-react'
import { Button } from '@/components/ui/button'
import { Reveal } from '@/components/reveal'

const inputClass =
  'w-full rounded-md border border-input bg-background px-3.5 py-2.5 text-sm text-foreground placeholder:text-muted-foreground/70 outline-none transition-colors focus:border-primary focus:ring-2 focus:ring-primary/25'

export function ContactSection() {
  const [sent, setSent] = useState(false)

  function handleSubmit(e: FormEvent<HTMLFormElement>) {
    e.preventDefault()
    setSent(true)
  }

  return (
    <section className="py-20 sm:py-24">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div className="grid gap-8 lg:grid-cols-5">
          {/* Form */}
          <Reveal className="lg:col-span-3">
            <div className="rounded-xl border border-border bg-card p-6 sm:p-8">
              {sent ? (
                <div className="flex min-h-[420px] flex-col items-center justify-center text-center">
                  <CheckCircle2 className="h-14 w-14 text-primary" />
                  <h3 className="mt-4 text-xl font-semibold">Thank you</h3>
                  <p className="mt-2 max-w-sm text-muted-foreground">
                    Your enquiry has been received. Our team will get back to you shortly to discuss
                    your requirement.
                  </p>
                </div>
              ) : (
                <form onSubmit={handleSubmit} className="grid gap-4 sm:grid-cols-2">
                  <div className="sm:col-span-1">
                    <label htmlFor="name" className="mb-1.5 block text-sm font-medium">
                      Name
                    </label>
                    <input id="name" name="name" required className={inputClass} placeholder="Your name" />
                  </div>
                  <div className="sm:col-span-1">
                    <label htmlFor="company" className="mb-1.5 block text-sm font-medium">
                      Company
                    </label>
                    <input id="company" name="company" className={inputClass} placeholder="Organisation" />
                  </div>
                  <div className="sm:col-span-1">
                    <label htmlFor="email" className="mb-1.5 block text-sm font-medium">
                      Email
                    </label>
                    <input
                      id="email"
                      name="email"
                      type="email"
                      required
                      className={inputClass}
                      placeholder="you@company.com"
                    />
                  </div>
                  <div className="sm:col-span-1">
                    <label htmlFor="phone" className="mb-1.5 block text-sm font-medium">
                      Phone
                    </label>
                    <input id="phone" name="phone" type="tel" className={inputClass} placeholder="+91" />
                  </div>
                  <div className="sm:col-span-2">
                    <label htmlFor="requirement" className="mb-1.5 block text-sm font-medium">
                      Project Requirement
                    </label>
                    <input
                      id="requirement"
                      name="requirement"
                      className={inputClass}
                      placeholder="e.g. IP surveillance, BMS, access control"
                    />
                  </div>
                  <div className="sm:col-span-2">
                    <label htmlFor="message" className="mb-1.5 block text-sm font-medium">
                      Message
                    </label>
                    <textarea
                      id="message"
                      name="message"
                      rows={4}
                      className={`${inputClass} resize-none`}
                      placeholder="Tell us about your facility and goals"
                    />
                  </div>
                  <div className="sm:col-span-2">
                    <Button type="submit" size="lg" className="w-full sm:w-auto">
                      Submit Enquiry
                    </Button>
                  </div>
                </form>
              )}
            </div>
          </Reveal>

          {/* Details + map */}
          <Reveal index={1} className="lg:col-span-2">
            <div className="flex h-full flex-col gap-6">
              <div className="rounded-xl border border-border bg-card p-6">
                <ul className="space-y-5">
                  <li className="flex items-start gap-3">
                    <Phone className="mt-0.5 h-5 w-5 shrink-0 text-primary" />
                    <div className="text-sm">
                      <p className="font-medium">Phone</p>
                      <a href="tel:+919352970001" className="block text-muted-foreground hover:text-foreground">
                        +91 93529 70001
                      </a>
                      <a href="tel:+919352930071" className="block text-muted-foreground hover:text-foreground">
                        
                      </a>
                      <a href="tel:+919829084113" className="block text-muted-foreground hover:text-foreground">
                        +91 98290 84113
                      </a>
                    </div>
                  </li>
                  <li className="flex items-start gap-3">
                    <Mail className="mt-0.5 h-5 w-5 shrink-0 text-primary" />
                    <div className="text-sm">
                      <p className="font-medium">Email</p>
                      <a href="mailto:ag@sacindia.co.in" className="block text-muted-foreground hover:text-foreground">
                        ag@sacindia.co.in
                      </a>
                      <a href="mailto:" className="block text-muted-foreground hover:text-foreground">
                        
                      </a>
                      <a href="mailto:am@sacindia.co.in" className="block text-muted-foreground hover:text-foreground">
                        am@sacindia.co.in
                      </a>
                    </div>
                  </li>
                  <li className="flex items-start gap-3">
                    <MapPin className="mt-0.5 h-5 w-5 shrink-0 text-primary" />
                    <div className="text-sm">
                      <p className="font-medium">Office</p>
                      <p className="leading-relaxed text-muted-foreground">
                        Plot No. C-5/2, Chitrakoot Scheme,
                        <br />
                        Ajmer Road, Jaipur &ndash; 302021
                      </p>
                    </div>
                  </li>
                </ul>
              </div>

              <div className="min-h-[220px] flex-1 overflow-hidden rounded-xl border border-border">
                <iframe
                  title="SAC office location on map"
                  src="https://www.google.com/maps?q=Chitrakoot,+Ajmer+Road,+Jaipur,+Rajasthan+302021&output=embed"
                  className="h-full min-h-[220px] w-full grayscale-[0.15] dark:grayscale-[0.2] dark:invert-[0.9] dark:hue-rotate-180"
                  loading="lazy"
                  referrerPolicy="no-referrer-when-downgrade"
                />
              </div>
            </div>
          </Reveal>
        </div>
      </div>
    </section>
  )
}

