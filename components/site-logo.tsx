import Image from 'next/image'
import Link from 'next/link'
import { cn } from '@/lib/utils'

const LOGO_WIDTH = 2086
const LOGO_HEIGHT = 754

const VARIANTS = {
  header: {
    className: 'w-[140px] sm:w-[170px] lg:w-[205px]',
    sizes: '(min-width: 1024px) 205px, (min-width: 640px) 170px, 140px',
  },
  footer: {
    className: 'w-[180px]',
    sizes: '180px',
  },
  menu: {
    className: 'w-[140px]',
    sizes: '140px',
  },
} as const

export function SiteLogo({
  className,
  variant = 'header',
  priority = false,
}: {
  className?: string
  variant?: keyof typeof VARIANTS
  priority?: boolean
}) {
  const { className: sizeClassName, sizes } = VARIANTS[variant]

  return (
    <Link
      href="/"
      className={cn('flex shrink-0 items-center', className)}
      aria-label="Secure Automation Consultants home"
    >
      <Image
        src="/images/sac-logo-teal.png"
        alt="SAC — business is people"
        width={LOGO_WIDTH}
        height={LOGO_HEIGHT}
        sizes={sizes}
        priority={priority}
        className={cn('h-auto max-w-none object-contain', sizeClassName)}
      />
    </Link>
  )
}
