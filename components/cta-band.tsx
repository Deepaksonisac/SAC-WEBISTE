'use client'

import Link from 'next/link'
import { motion } from 'framer-motion'
import { ArrowRight } from 'lucide-react'
import { Button } from '@/components/ui/button'

export function CtaBand({
  title = "Let's engineer your next secure facility",
  subtitle = 'Tell us about your site and requirements. Our engineers will design the right mix of security, management and automation systems.',
}: {
  title?: string
  subtitle?: string
}) {
  return (
    <section className="py-20 sm:py-24">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <motion.div
          initial={{ opacity: 0, y: 24 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true, margin: '-80px' }}
          transition={{ duration: 0.6 }}
          className="relative overflow-hidden rounded-2xl bg-primary px-6 py-14 text-center sm:px-12 sm:py-16"
        >
          <div
            aria-hidden="true"
            className="pointer-events-none absolute -left-16 -top-16 h-56 w-56 rounded-full bg-primary-foreground/10 blur-3xl"
          />
          <div
            aria-hidden="true"
            className="pointer-events-none absolute -bottom-20 -right-10 h-64 w-64 rounded-full bg-primary-foreground/10 blur-3xl"
          />
          <h2 className="relative mx-auto max-w-2xl text-balance text-3xl font-bold tracking-tight text-primary-foreground sm:text-4xl">
            {title}
          </h2>
          <p className="relative mx-auto mt-5 max-w-2xl text-pretty leading-relaxed text-primary-foreground/85">
            {subtitle}
          </p>
          <div className="relative mt-8">
            <Button
              size="lg"
              variant="secondary"
              className="group"
              nativeButton={false}
              render={
                <Link href="/contact">
                  Get a Consultation
                  <ArrowRight className="ml-1 h-4 w-4 transition-transform group-hover:translate-x-1" />
                </Link>
              }
            />
          </div>
        </motion.div>
      </div>
    </section>
  )
}
